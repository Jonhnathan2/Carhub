document.addEventListener("DOMContentLoaded", function() {
    const zoomToggleBtn = document.getElementById("zoomToggle");
    const images = document.querySelectorAll("#carouselExteriorModal .zoomable");
    let isZoomed = false;
    let isDragging = false;
    let startX, startY;
    let currentX = 0,
        currentY = 0;

    // Xử lý sự kiện click vào nút Zoom
    zoomToggleBtn.addEventListener("click", () => {
        isZoomed = !isZoomed;

        images.forEach((image) => {
            if (isZoomed) {
                image.classList.add("zoomed");
                image.style.transform = `scale(2) translate(0px, 0px)`; // Phóng to mượt mà
                zoomToggleBtn.className = 'fa fa-search-minus mb-3';
            } else {
                image.classList.remove("zoomed");
                image.style.transform = "scale(1) translate(0px, 0px)"; // Thu nhỏ lại
                isDragging = false;
                currentX = currentY = 0;
                zoomToggleBtn.className = 'fa fa-search-plus mb-3';
            }
        });
    });

    // Sự kiện kéo ảnh khi đã phóng to
    images.forEach((image) => {
        image.addEventListener("mousedown", (e) => {
            if (isZoomed) {
                isDragging = true;
                startX = e.clientX - currentX;
                startY = e.clientY - currentY;
                image.style.cursor = "grabbing";
                e.preventDefault();
            }
        });

        document.addEventListener("mousemove", (e) => {
            if (isDragging && isZoomed) {
                currentX = e.clientX - startX;
                currentY = e.clientY - startY;
                image.style.transform = `scale(1.8) translate(${currentX}px, ${currentY}px)`;
            }
        });

        document.addEventListener("mouseup", () => {
            isDragging = false;
            image.style.cursor = "grab";
        });
    });
});
document.querySelectorAll(".img-mask").forEach(function (mask) {
    mask.addEventListener("click", function () {
        // Mở modal bằng cách sử dụng Bootstrap
        var modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    });
});