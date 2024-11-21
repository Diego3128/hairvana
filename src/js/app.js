//paginator
let sectionStep = 1;
const initialStep = 1;
const lastStep = 3;
//info about an appointment
const appointment = {
    id: "",
    name: "",
    date: "",
    hour: "",
    services: []
}
Object.seal(appointment);// not allowed to created other attributes

document.addEventListener("DOMContentLoaded", function () {
    startApp();
})

//starts the functionality of the app
function startApp() {
    //show the section related to the current tab
    showSection();
    //changes the section when creating an appointment
    tabs();
    //hides or shows paginator buttons depending on the current section step
    paginatorBtns();
    //update page using paginator buttons
    updatePage();
    //fetch services from the api
    fetchAPI();
    //update the appointment's name attribute
    customerInfo();
    //update the appointment's date attribute
    chooseDate();
    //update the appointment's hour attribute
    chooseHour();
    //show summary with the appointment info
    showSummary();
}
//shows the section related to the tab
function showSection() {
    //hide the previous section
    const previousSection = document.querySelector(".section.show") || null;
    if (previousSection) previousSection.classList.remove("show")
    //show section
    const section = document.getElementById(`step-${sectionStep}`) || null;
    if (section) section.classList.add("show");
}
//changes the section when clicking on a tab
function tabs() {
    //add listener to the container of the tabs
    document.getElementById("tabs").addEventListener("click", function (e) {
        //return if the target is not a button
        if (!e.target.classList.contains("tab")) return;
        //tab clicked
        const tab = e.target;
        //update sectionStep variable
        sectionStep = parseInt(tab.dataset.step, 10) || null;
        //updateCurrentTabStyle
        updateCurrentTabStyle();
        //show section
        showSection();
        //check buttons
        paginatorBtns();
    });
}
//hides or shows paginator buttons depending on the current section step
function paginatorBtns() {
    const nextPageBtn = document.getElementById("next");
    const previousPageBtn = document.getElementById("previous");

    if (sectionStep === 1) {
        previousPageBtn.classList.add("hide");
        nextPageBtn.classList.remove("hide");
    } else if (sectionStep === 3) {
        nextPageBtn.classList.add("hide");
        previousPageBtn.classList.remove("hide");
        //show the general summary
        showSummary();
    } else {
        previousPageBtn.classList.remove("hide");
        nextPageBtn.classList.remove("hide");
    }
    showSection();
    updateCurrentTabStyle();
}
//check current tab dependig on the current step
function updateCurrentTabStyle() {
    //delete previus tab style
    const previousTab = document.querySelector(".tab-current") || null;
    if (previousTab) previousTab.classList.remove("tab-current");
    //select current tab depending on the step
    const currentTab = document.querySelector(`[data-step="${sectionStep}"]`);
    //add style
    currentTab.classList.add("tab-current");
}
//changes the section using the buttons
function updatePage() {
    const nextPageBtn = document.getElementById("next");
    const previousPageBtn = document.getElementById("previous");
    //show previous page
    previousPageBtn.addEventListener("click", function () {
        if (sectionStep <= initialStep) return;
        sectionStep--;
        paginatorBtns();
    })
    //show next page
    nextPageBtn.addEventListener("click", function () {
        if (sectionStep >= lastStep) return;
        sectionStep++;
        paginatorBtns();
    });
}
//fetch services from the api
async function fetchAPI() {
    try {
        const URL = "http://localhost:3000/api/services";
        const result = await fetch(URL);
        const data = await result.json();
        showServices(data);
    } catch (error) {
        console.log(new Error(error));
    }
}
//show services
function showServices(services) {
    const serviceContainer = document.getElementById("service-container") || null;

    if (serviceContainer) {
        //append each service
        services.forEach(service => {
            const { id, name, price } = service;
            //service element
            const serviceElement = document.createElement("DIV");
            serviceElement.dataset.serviceId = id;
            serviceElement.classList.add("service");
            //onclick send the service
            serviceElement.onclick = () => { pickService(service) };
            //service name element
            const serviceName = document.createElement("P");
            serviceName.textContent = name;
            serviceName.classList.add("service__name");
            //service price element
            const servicePrice = document.createElement("P");
            servicePrice.textContent = price;
            servicePrice.classList.add("service__price");
            //append details into the service
            serviceElement.append(serviceName, servicePrice);
            //append service into the service container element
            serviceContainer.append(serviceElement)
        })
    }
}
//add a new service
function pickService(service) {
    const { services } = appointment;
    const { id } = service;
    //clicked element in the DOM
    const serviceElement = document.querySelector(`[data-service-id='${id}']`) || null;

    //chekc if the service already exists in the array
    if (services.some(addedService => addedService.id === id)) {
        //delete the service from the array
        const updatedServices = services.filter(addedService => addedService.id !== id);
        appointment.services = updatedServices;
        //delete the style of selected service
        if (serviceElement) serviceElement.classList.remove("selected");
        return;
    }
    //push the new service
    appointment.services = [...services, service];
    //change the styles of the element
    if (serviceElement) serviceElement.classList.add("selected");
}
// add the customer's info to the appointment object
function customerInfo() {
    appointment.name = document.getElementById("customer-name").value || "";
    appointment.id = document.querySelector(".user-id").value || "";
}
// add the customer's chosen date to the appointment object
function chooseDate() {
    const dateElement = document.getElementById("date") || null;
    if (dateElement) dateElement.addEventListener("input", function () {
        //split element of the date
        const [year, month, day] = this.value.split('-');
        //date to local time
        const date = new Date(year, month - 1, day);
        //current date
        const currentDate = new Date();

        //check if it's a weekend
        const chosenDay = date.getUTCDay();
        if ([0, 6].includes(chosenDay)) {
            // it's sunday or saturday
            this.value = appointment.date;
            //show alert
            showAlert("No hay servicios los fines de semana", "error", ".alerts");
            return;
        }
        //check if the date is in the past
        if ((date.getDate() <= currentDate.getDate() && date.getMonth <= currentDate.getMonth()) || date.getTime() <= currentDate.getTime()) {
            this.value = appointment.date;
            showAlert("Fecha incorrecta", "error", ".alerts");
            return;
        }
        //save date
        appointment.date = this.value;

    })
}
// add the customer's chosen hour to the appointment object
function chooseHour() {
    const timeElement = document.getElementById("time") || null;
    if (timeElement) timeElement.addEventListener("input", function () {
        const [hour, minutes] = this.value.split(":")
        //hour between 8:00am and 6:00pm
        if (hour < '08' || hour > '17' || (hour >= '17' && minutes > '30')) {
            this.value = '';
            showAlert("Servicio solo de 8:00am a 5:30pm", "error", ".alerts");

        } else {
            //correct hour
            appointment.hour = this.value;
        }
    });
}
//delete an element
function deleteAlert(element = null) {
    if (element) element.remove();
}
//shows alerts
function showAlert(message = '', type = '', selector = 'body', permanent = false) {
    //check if an alert is already being shown
    const previousAlert = document.querySelector(".alert") || null;
    if (previousAlert) deleteAlert(previousAlert);
    //alert element
    const alert = document.createElement("div");
    alert.classList.add("alert", type);
    alert.innerText = message;
    //append below the given element
    const element = document.querySelector(selector) || null;
    if (element) {
        //insert after the element
        element.append(alert);
        //if the alert it's not permanent then hide it after 6s
        if (!permanent) {
            //hide alert (after 6s)
            setTimeout(() => {
                deleteAlert(alert);
            }, 6000)
        }
    }
}
//show a summary of the appointment
function showSummary() {
    const summary = document.querySelector(".summary-content") || null;
    //clean previous content
    if (summary) while (summary.firstChild) summary.firstChild.remove();

    //check if the info is correct
    if (Object.values(appointment).includes("") || appointment.services.length === 0) {
        showAlert("Faltan datos para la cita", "error", ".summary-content", true);
        return;
    }
    //show summary
    const { name, date, hour, services } = appointment;
    //service info (container)
    const appointmentServices = document.createElement("DIV");
    appointmentServices.classList.add("appointment-services");
    //heading for service summary
    const serviceHeading = document.createElement("H3");
    serviceHeading.textContent = "Resumen de servicios";
    appointmentServices.appendChild(serviceHeading);

    //iterate and create each service
    services.forEach(service => {
        const { name, price } = service;
        const serviceElement = document.createElement("DIV");
        serviceElement.classList.add("service-element");

        const serviceText = document.createElement("P");
        serviceText.textContent = name;

        const servicePrice = document.createElement("P");
        servicePrice.innerHTML = `<span>Precio: </span> $${price}`;

        serviceElement.append(serviceText, servicePrice);
        appointmentServices.append(serviceElement);
    })
    //appointment and user info
    const appointmentInfo = document.createElement("DIV");
    appointmentInfo.classList.add("appointment-info");
    //heading for service summary
    const headingAppointment = document.createElement("H3");
    headingAppointment.textContent = "Resumen de la cita";
    appointmentInfo.appendChild(headingAppointment);

    const customerName = document.createElement("P");
    customerName.innerHTML = `<span>Nombre:</span> ${name}`;

    //format date and hour in spanish
    const formattedDate = formatDate(date, "es-CO");
    const formattedHour = formatHour(hour, "es-CO");

    const appointmentDate = document.createElement("P");
    appointmentDate.innerHTML = `<span>Fecha:</span> ${formattedDate}`;

    const appointmentHour = document.createElement("P");
    appointmentHour.innerHTML = `<span>Hora:</span> ${formattedHour}`;

    appointmentInfo.append(customerName, appointmentDate, appointmentHour);

    //button to date an appointment
    const bookButton = document.createElement("BUTTON");
    bookButton.classList.add("button", "submit");
    bookButton.textContent = "Reservar Cita";
    bookButton.addEventListener("click", bookAppointment);
    //append elements
    summary.append(appointmentServices, appointmentInfo, bookButton);
}
//format date to a specific location
function formatDate(date, region) {
    try {
        const [year, month, day] = date.split("-");
        const parsedDate = new Date(year, month - 1, day);
        return parsedDate.toLocaleDateString(region, { day: "numeric", weekday: "long", month: "long", year: "numeric" });
    } catch (e) {
        return date;
    }
}
//format hour
function formatHour(hour, region) {
    try {
        const [h, m] = hour.split(":");
        const parsedHour = new Date(0, 0, 0, h, m);
        return parsedHour.toLocaleTimeString(region, { hour: "numeric", minute: "numeric", hour12: true });
    } catch (e) {
        return hour;
    }
}
//
async function bookAppointment() {
    const { id, date, name, hour, services } = appointment;
    const serviceId = services.map(service => service.id)

    const formData = new FormData();
    formData.set("date", date);
    formData.set("hour", hour);
    formData.set("userId", id);
    formData.set("services", serviceId);

    try {
        //post request to the API
        const URL = "http://localhost:3000/api/appointments";
        const response = await fetch(URL, {
            method: "post",
            body: formData
        });
        const result = await response.json();

        if (result.result) {
            Swal.fire({
                title: "Cita agendada correctamente!",
                text: "Gracias por usas nuestros servicios " + name + ".",
                icon: "success"
            }).then(() => {
                window.location.reload();
            })
        }
    } catch (e) {
        Swal.fire({
            title: "Error",
            text: "Ocurrio un error. Intenta más tarde...",
            icon: "error"
        }).then(() => {
            window.location.reload();
        })
    }
}
