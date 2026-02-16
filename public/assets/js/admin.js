/* ================================
   SIDEBAR TOGGLE
================================ */

const menuToggle = document.getElementById("menuToggle");
const sidebar = document.getElementById("sidebar");
const closeSidebar = document.getElementById("closeSidebar");
const overlay = document.getElementById("overlay");

menuToggle?.addEventListener("click", () => {
    sidebar?.classList.add("active");
    overlay?.classList.add("active");
});

closeSidebar?.addEventListener("click", () => {
    sidebar?.classList.remove("active");
    overlay?.classList.remove("active");
});

overlay?.addEventListener("click", () => {
    sidebar?.classList.remove("active");
    overlay?.classList.remove("active");
});


/* ================================
   NOTIFICATION DROPDOWN
================================ */

const notificationToggle = document.getElementById("notificationToggle");
const notificationDropdown = document.getElementById("notificationDropdown");

notificationToggle?.addEventListener("click", e => {
    e.stopPropagation();
    notificationDropdown?.classList.toggle("active");
});

document.addEventListener("click", () => {
    notificationDropdown?.classList.remove("active");
});


/* ================================
   TAB SYSTEM
================================ */

document.querySelectorAll(".tab-btn").forEach(btn => {
    btn.addEventListener("click", () => {

        document.querySelectorAll(".tab-btn")
            .forEach(b => b.classList.remove("active"));

        document.querySelectorAll(".tab-content")
            .forEach(c => c.classList.remove("active"));

        btn.classList.add("active");

        const target = document.getElementById(btn.dataset.tab);
        target?.classList.add("active");
    });
});


/* ================================
   ADMIN FINANCE CHART
================================ */

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
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}


/* ================================
   BANDANI SPEEDOMETER GAUGE
================================ */

const speedGauge = document.getElementById("monthlyBreakdownChart");

if (speedGauge) {

    const totalSales = 1250000;

    const mshahara = 125000;
    const umeme = 40000;
    const kodi = 80000;

    const used = mshahara + umeme + kodi;
    const remaining = totalSales - used;

    let percentage = (remaining / totalSales) * 100;
    percentage = Math.max(0, Math.min(100, percentage));

    const gaugeNeedle = {
        id: "gaugeNeedle",
        afterDatasetDraw(chart) {

            const { ctx } = chart;
            const meta = chart.getDatasetMeta(0);
            const cx = meta.data[0].x;
            const cy = meta.data[0].y;

            const angle = Math.PI + (percentage / 100) * Math.PI;

            ctx.save();
            ctx.translate(cx, cy);
            ctx.rotate(angle);

            ctx.beginPath();
            ctx.moveTo(0, -2);
            ctx.lineTo(chart.width / 4, 0);
            ctx.lineTo(0, 2);
            ctx.fillStyle = "#111";
            ctx.fill();

            ctx.restore();

            ctx.beginPath();
            ctx.arc(cx, cy, 6, 0, 2 * Math.PI);
            ctx.fillStyle = "#111";
            ctx.fill();
        }
    };

    new Chart(speedGauge, {
        type: "doughnut",
        data: {
            labels: ["Salary","Electricity","Rent","Remaining"],
            datasets: [{
                data: [mshahara, umeme, kodi, remaining],
                backgroundColor: [
                    "#dc2626",
                    "#f59e0b",
                    "#3b82f6",
                    "#16a34a"
                ],
                borderWidth: 0
            }]
        },
        options: {
            rotation: -90,
            circumference: 180,
            cutout: "70%",
            plugins: {
                legend: {
                    position: "bottom"
                }
            },
            responsive: true,
            maintainAspectRatio: false
        },
        plugins: [gaugeNeedle]
    });
}


/* ================================
   BANDANI WEEKLY SALES
================================ */

const weekly = document.getElementById("weeklySalesChart");

if (weekly) {
    new Chart(weekly, {
        type: "bar",
        data: {
            labels: ["Mon","Tue","Wed","Thu","Fri","Sat","Sun"],
            datasets: [{
                label: "Sales",
                data: [120000,150000,180000,90000,210000,170000,140000],
                backgroundColor: "#0f172a"
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}