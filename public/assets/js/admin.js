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
            maintainAspectRatio: false,
            animation: { duration: 1200 }
        }
    });
}


/* ================================
   BANDANI SPEEDOMETER GAUGE
   (UPDATED SECTION ONLY)
================================ */

function createBandaniSpeedometer(canvas) {

    const dailyEstimate = 30000;
    const today = new Date().getDate();
    const monthlySales = dailyEstimate * today;
    const monthlyTarget = 1200000;

    const finalPercentage = Math.min(
        (monthlySales / monthlyTarget) * 100,
        100
    );

    let performanceColor = "#dc2626";
    if (finalPercentage >= 40) performanceColor = "#f59e0b";
    if (finalPercentage >= 70) performanceColor = "#16a34a";

    let animatedValue = 0;

    const gaugePlugin = {
        id: "gaugePlugin",
        afterDraw(chart) {

            const { ctx } = chart;
            const meta = chart.getDatasetMeta(0);
            const cx = meta.data[0].x;
            const cy = meta.data[0].y;

            animatedValue += (finalPercentage - animatedValue) * 0.06;

            const angle = Math.PI + (animatedValue / 100) * Math.PI;

            /* Draw needle */
            ctx.save();
            ctx.translate(cx, cy);
            ctx.rotate(angle);

            ctx.beginPath();
            ctx.moveTo(0, -3);
            ctx.lineTo(chart.width / 4, 0);
            ctx.lineTo(0, 3);
            ctx.fillStyle = "#111";
            ctx.fill();
            ctx.restore();

            /* Center pivot */
            ctx.beginPath();
            ctx.arc(cx, cy, 6, 0, 2 * Math.PI);
            ctx.fillStyle = "#111";
            ctx.fill();

            /* Percentage text moved lower */
            ctx.save();
            ctx.font = "bold 22px Arial";
            ctx.fillStyle = performanceColor;
            ctx.textAlign = "center";
            ctx.fillText(
                Math.round(animatedValue) + "%",
                cx,
                cy + 28  // moved lower
            );
            ctx.restore();

            if (Math.abs(animatedValue - finalPercentage) > 0.5) {
                requestAnimationFrame(() => chart.draw());
            }
        }
    };

    new Chart(canvas, {
        type: "doughnut",
        data: {
            datasets: [{
                data: [25, 25, 25, 25],
                backgroundColor: [
                    "#dc2626",
                    "#f59e0b",
                    "#22c55e",
                    "#16a34a"
                ],
                borderWidth: 0
            }]
        },
        options: {
            rotation: -90,
            circumference: 180,
            cutout: "70%",
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            plugins: {
                legend: { display: false }
            }
        },
        plugins: [gaugePlugin]
    });
}


/* ================================
   BANDANI WEEKLY SALES
================================ */

function createWeeklySalesChart(canvas) {

    new Chart(canvas, {
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
            maintainAspectRatio: false,
            animation: {
                duration: 1500,
                easing: "easeOutQuart"
            }
        }
    });
}


/* ================================
   INTERSECTION OBSERVER
   (Gauge delayed only)
================================ */

const observer = new IntersectionObserver((entries, obs) => {

    entries.forEach(entry => {

        if (entry.isIntersecting) {

            const canvas = entry.target;

            if (!canvas.dataset.rendered) {

                if (canvas.id === "monthlyBreakdownChart") {

                    // Delay speedometer start by 10 seconds
                    setTimeout(() => {
                        createBandaniSpeedometer(canvas);
                    }, 500);
                }

                if (canvas.id === "weeklySalesChart") {
                    createWeeklySalesChart(canvas);
                }

                canvas.dataset.rendered = "true";
                canvas.classList.add("chart-visible");
            }

            obs.unobserve(canvas);
        }

    });

}, { threshold: 0.3 });


/* Attach observer safely */
const bandaniGauge = document.getElementById("monthlyBreakdownChart");
const weeklyChart = document.getElementById("weeklySalesChart");

if (bandaniGauge) observer.observe(bandaniGauge);
if (weeklyChart) observer.observe(weeklyChart);