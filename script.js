function toggleMenu() {
    var menu = document.getElementById("menuSidebar");
    menu.classList.toggle("active");
}

// ตรวจจับการคลิกที่ส่วนอื่นของหน้าเว็บ
window.addEventListener("click", function(event) {
    var menu = document.getElementById("menuSidebar");
    var menuButton = document.querySelector(".hamburger-icon"); // ปุ่ม ☰

    // ถ้าคลิกไม่ใช่ที่เมนู หรือปุ่ม ☰ → ซ่อนเมนู
    if (!menu.contains(event.target) && !menuButton.contains(event.target)) {
        menu.classList.remove("active");
    }
});
