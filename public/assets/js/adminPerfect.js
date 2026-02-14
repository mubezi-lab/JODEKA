/* =========================
   SIDEBAR TOGGLE
========================= */

const menuToggle = document.getElementById("menuToggle");
const sidebar = document.getElementById("sidebar");
const closeSidebar = document.getElementById("closeSidebar");

menuToggle?.addEventListener("click", () => {
    sidebar.classList.add("active");
});

closeSidebar?.addEventListener("click", () => {
    sidebar.classList.remove("active");
});

/* =========================
   TAB SYSTEM
========================= */

const tabButtons = document.querySelectorAll(".tab-btn");
const tabContents = document.querySelectorAll(".tab-content");

tabButtons.forEach(btn => {
    btn.addEventListener("click", () => {

        tabButtons.forEach(b => b.classList.remove("active"));
        tabContents.forEach(c => c.classList.remove("active"));

        btn.classList.add("active");

        const target = btn.getAttribute("data-tab");
        document.getElementById(target)?.classList.add("active");
    });
});

/* =========================
   MODAL SYSTEM
========================= */

document.querySelectorAll("[data-modal]").forEach(button => {
    button.addEventListener("click", () => {
        const modalId = button.getAttribute("data-modal");
        document.getElementById(modalId)?.classList.add("active");
    });
});

document.querySelectorAll(".modal").forEach(modal => {
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.classList.remove("active");
        }
    });
});

/* =========================
   CHART.JS (Finance Chart)
========================= */

const ctx = document.getElementById("financeChart");

if (ctx) {
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
            datasets: [
                {
                    label: "Income",
                    data: [0, 0, 0, 0, 0, 0],
                    backgroundColor: "#16a34a"
                },
                {
                    label: "Expenses",
                    data: [0, 0, 0, 0, 0, 0],
                    backgroundColor: "#dc2626"
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}