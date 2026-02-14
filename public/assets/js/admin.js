const menuToggle = document.getElementById("menuToggle");
const sidebar = document.getElementById("sidebar");
const closeSidebar = document.getElementById("closeSidebar");
const overlay = document.getElementById("overlay");

menuToggle?.addEventListener("click", () => {
    sidebar.classList.add("active");
    overlay?.classList.add("active");
});

closeSidebar?.addEventListener("click", () => {
    sidebar.classList.remove("active");
    overlay?.classList.remove("active");
});

overlay?.addEventListener("click", () => {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
});

const notificationToggle = document.getElementById("notificationToggle");
const notificationDropdown = document.getElementById("notificationDropdown");

notificationToggle?.addEventListener("click", e => {
    e.stopPropagation();
    notificationDropdown.classList.toggle("active");
});

document.addEventListener("click", () => {
    notificationDropdown?.classList.remove("active");
});

document.querySelectorAll(".tab-btn").forEach(btn => {
    btn.addEventListener("click", () => {
        document.querySelectorAll(".tab-btn").forEach(b => b.classList.remove("active"));
        document.querySelectorAll(".tab-content").forEach(c => c.classList.remove("active"));
        btn.classList.add("active");
        document.getElementById(btn.dataset.tab)?.classList.add("active");
    });
});

const ctx = document.getElementById("financeChart");
if (ctx) {
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Jan","Feb","Mar","Apr","May","Jun"],
            datasets: [
                { label: "Income", data: [0,0,0,0,0,0], backgroundColor: "#16a34a" },
                { label: "Expenses", data: [0,0,0,0,0,0], backgroundColor: "#dc2626" }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
}