// Hàm lọc xe dựa trên các giá trị lọc
function filterCars(transmission, bodyStyle, startYear, endYear) {
    const urlParams = new URLSearchParams(window.location.search);
    
    // Thiết lập lọc transmission
    if (transmission !== null) {
        urlParams.set('transmission', transmission);
    }
    
    // Thiết lập lọc body_style
    if (bodyStyle !== null) {
        urlParams.set('body_style', bodyStyle);
    }

    // Thiết lập lọc năm bắt đầu và kết thúc
    if (startYear !== null) {
        urlParams.set('start_year', startYear);
    }
    if (endYear !== null) {
        urlParams.set('end_year', endYear);
    }

    // Tải lại trang với URL đã được cập nhật tham số lọc
    window.location.search = urlParams.toString();
}

// Hàm để tạo các tùy chọn cho năm trong dropdown
function populateYears() {
    const startYearSelect = document.getElementById('startYear');
    const endYearSelect = document.getElementById('endYear');
    const currentYear = new Date().getFullYear();
    
    // Điền các năm từ 1980 đến năm hiện tại cho "From" và "To"
    for (let year = 1980; year <= currentYear; year++) {
        let optionFrom = document.createElement('option');
        optionFrom.value = year;
        optionFrom.innerText = year;
        startYearSelect.appendChild(optionFrom);
  
        let optionTo = document.createElement('option');
        optionTo.value = year;
        optionTo.innerText = year;
        endYearSelect.appendChild(optionTo);
    }

    // Khi thay đổi năm bắt đầu (From)
    startYearSelect.addEventListener('change', function() {
        const selectedYear = parseInt(startYearSelect.value);
        
        // Xóa tất cả các tùy chọn trong "To"
        endYearSelect.innerHTML = '';
    
        // Tạo các tùy chọn cho "To" bắt đầu từ năm đã chọn
        for (let year = selectedYear; year <= currentYear; year++) {
            const optionTo = document.createElement("option");
            optionTo.value = year;
            optionTo.textContent = year;
            endYearSelect.appendChild(optionTo);
        }
        
        // Nếu "To" nhỏ hơn "From", đặt lại giá trị
        if (parseInt(endYearSelect.value) < selectedYear) {
            endYearSelect.value = currentYear;
        }
        
    });

    // Khi thay đổi năm kết thúc (To)
    endYearSelect.addEventListener('change', function() {
        filterCars(null, null, startYearSelect.value, endYearSelect.value);
    });
}

// Gọi hàm populateYears khi trang được tải
window.onload = populateYears;


