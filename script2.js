document.addEventListener("DOMContentLoaded", function () {
    // ฟังก์ชันเปิด/ปิดเมนู
    function toggleMenu() {
        let menu = document.getElementById("menuSidebar");
        menu.classList.toggle("active");
    }

    // กำหนดให้ไอคอนเมนูเรียกใช้ฟังก์ชัน toggleMenu()
    let hamburgerIcon = document.querySelector(".hamburger-icon");
    if (hamburgerIcon) {
        hamburgerIcon.addEventListener("click", toggleMenu);
    }

    // ฟังก์ชันเปลี่ยนหน้า
    function navigateTo(url) {
        window.location.href = url;
    }

    // กำหนดให้ปุ่มเมนูสามารถคลิกเพื่อนำไปยังหน้าที่เกี่ยวข้อง
    document.querySelectorAll(".menu-item").forEach(item => {
        item.addEventListener("click", function () {
            let targetUrl = this.getAttribute("data-url");
            if (targetUrl) {
                navigateTo(targetUrl);
            }
        });
    });

    // กำหนดให้ปุ่ม dropdown แสดงเมนูเมื่อคลิก
    let dropdownButton = document.querySelector(".dropbtn");
    if (dropdownButton) {
        dropdownButton.addEventListener("click", function () {
            let dropdownContent = document.querySelector(".dropdown-content");
            dropdownContent.classList.toggle("show");
        });
    }

    // ซ่อน dropdown เมื่อนอกคลิก
    window.addEventListener("click", function (event) {
        if (!event.target.matches(".dropbtn")) {
            let dropdowns = document.querySelectorAll(".dropdown-content");
            dropdowns.forEach(dropdown => {
                if (dropdown.classList.contains("show")) {
                    dropdown.classList.remove("show");
                }
            });
        }
    });
});
