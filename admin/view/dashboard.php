<?php
$dashboard_query = $mysqli->prepare("
    SELECT
        COUNT(DISTINCT u.user_id) AS total_users,
        COUNT(CASE WHEN c.sold = 0 THEN c.car_id END) AS cars_for_sale,
        COUNT(CASE WHEN c.sold = 1 THEN c.car_id END) AS cars_sold,
        COUNT(CASE WHEN u.role = 0 THEN u.user_id END) AS private_party,
        COUNT(CASE WHEN u.role = 1 THEN u.user_id END) AS dealer,
        COUNT(CASE WHEN u.role = 2 THEN u.user_id END) AS manufacturer,
        COUNT(CASE WHEN u.role = 3 THEN u.user_id END) AS administrator
    FROM user u
    LEFT JOIN car c ON u.user_id = c.seller_id;
");
$dashboard_query->execute();
$dashboard_query->bind_result($totalUsers, $carsForSale, $carsSold, $privateParty, $dealer, $manufacturer, $administrator);
$dashboard_query->fetch();
$dashboard_query->close();

// Top 5 người đăng bài nhiều nhất
$topPosters_query = $mysqli->prepare("
    SELECT 
        u.user_id,
        u.name AS user_name,
        COUNT(c.car_id) AS total_posts,
        COUNT(CASE WHEN c.sold = 1 THEN c.car_id END) AS total_sold
    FROM 
        user u
    LEFT JOIN 
        car c ON u.user_id = c.seller_id
    GROUP BY 
        u.user_id
    ORDER BY 
        total_posts DESC
    LIMIT 5;
");
$topPosters_query->execute();
$topPosters_query->bind_result($userId, $userName, $totalPosts, $totalSold);

// Lưu dữ liệu top 5 người đăng bài vào mảng
$topPosters = [];
while ($topPosters_query->fetch()) {
    $topPosters[] = [
        'user_id' => $userId,
        'user_name' => $userName,
        'total_posts' => $totalPosts,
        'total_sold' => $totalSold
    ];
}
$topPosters_query->close();
?>


<div class="w-100 flex justify-between">
  <div class="flex flex-col w-1/4 px-4 py-3 bg-[#383838] rounded-lg">
    <p class="text-[#858585] font-bold">Number of Users</p>
    <div class="flex items-end pt-3">
      <h1 class="text-5xl pe-4 font-bold"><?= $totalUsers ?></h1>
      <p class="text-[#858585]">Users</p>
    </div>
  </div>
  <div class="flex flex-col w-1/4 px-4 py-3 bg-[#383838] rounded-lg">
    <p class="text-[#858585] font-bold">Number of Sold Cars</p>
    <div class="flex items-end pt-3">
      <h1 class="text-5xl pe-4 font-bold"><?= $carsSold ?></h1>
      <p class="text-[#858585]">Cars</p>
    </div>
  </div>
  <div class="flex flex-col w-1/4 px-4 py-3 bg-[#383838] rounded-lg">
    <p class="text-[#858585] font-bold">Number of For Selling Cars</p>
    <div class="flex items-end pt-3">
      <h1 class="text-5xl pe-4 font-bold"><?= $carsForSale ?></h1>
      <p class="text-[#858585]">Cars</p>
    </div>
  </div>
</div>

<div class="flex justify-between">
  <div class="flex flex-col gap-3 my-14 px-4 py-3 w-[47.5%] bg-[#383838] rounded-lg">
    <h1 class="text-xl pt-2 text-[#858585] font-bold">Number of users by role</h1>
    <div id="userByRole"></div>
  </div>
  <div class="flex flex-col gap-3 my-14 px-4 py-3 w-[47.5%] bg-[#383838] rounded-lg">
    <h1 class="text-xl pt-2 text-[#858585] font-bold">Top 5 people posting the most sales</h1>
    <table class="w-full table-auto text-base text-left divide divide-y divide-[#858585] max-h-full">
      <thead class="text-[#858585]">
        <tr>
          <th class="p-4 w-1/12">#</th>
          <th class="p-4 w">Name</th>
          <th class="p-4">Number of Cars Posted</th>
          <th class="p-4">Number of Cars Sold</th>
        </tr>
      </thead>
      <tbody class="text-base/7">
        <?php
          $i = 1 ;
          foreach ($topPosters as $poster):
        ?>
          <tr>
            <td class="p-4"><?= $i++ ?></td>
            <td class="p-4"><?= $poster['user_name'] ?></td>
            <td class="p-4"><?= $poster['total_posts'] ?></td>
            <td class="p-4"><?= $poster['total_sold'] ?></td>
          </tr>
        <?php endforeach; ?>        
      </tbody>
    </table>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
  var options_userByRole = {
    chart: {
      type: 'bar',
      toolbar: false
    },
    series: [{
      name: 'Users',
      data: [{
        x: 'Private Party',
        y: <?= $privateParty ?>
      }, {
        x: 'Dealer',
        y: <?= $dealer ?>
      }, {
        x: 'Manufacturer',
        y: <?= $manufacturer ?>
      }, {
        x: 'Administrator',
        y: <?= $administrator ?>
      }]
    }],
    xaxis: {
      labels: {
        style: {
          colors: '#FFFFFF',
          fontSize: '12px'
        }
      }
    },
    yaxis: {
      labels: {
        style: {
          colors: '#FFFFFF',
          fontSize: '12px'
        }
      }
    },
    tooltip: {
      theme: 'dark'
    },
  }

  var chart_userByRole = new ApexCharts(document.querySelector("#userByRole"), options_userByRole);

  chart_userByRole.render();
</script>