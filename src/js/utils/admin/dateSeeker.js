document.addEventListener("DOMContentLoaded", function () {
    startApp();
})

//starts the functionality of the app
function startApp() {
    serchByDate();
}

function serchByDate() {

    const searchAptBtn = document.getElementById("seek-apt") || null;

    if (searchAptBtn) searchAptBtn.addEventListener("click", searchAppointments);

}

function searchAppointments(e) {
    e.preventDefault();

    const datePicker = document.getElementById("date") || null;

    if (datePicker) {
        const date = datePicker.value; //format: year-month-day
        // redirect adding the date as a query param to the url
        window.location = `?date=${date}`;
    }

}