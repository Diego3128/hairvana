let sectionStep = 1;
const initialStep = 1;
const lastStep = 3;

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

}

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
//show the section related to the tab
function showSection() {
    //hide the previous section
    const previousSection = document.querySelector(".section.show") || null;
    if (previousSection) previousSection.classList.remove("show")
    //show section
    const section = document.getElementById(`step-${sectionStep}`) || null;
    if (section) section.classList.add("show");
}
//
function paginatorBtns() {
    const nextPageBtn = document.getElementById("next");
    const previousPageBtn = document.getElementById("previous");

    if (sectionStep === 1) {
        previousPageBtn.classList.add("hide");
        nextPageBtn.classList.remove("hide");
    } else if (sectionStep === 3) {
        nextPageBtn.classList.add("hide");
        previousPageBtn.classList.remove("hide");
    } else {
        previousPageBtn.classList.remove("hide");
        nextPageBtn.classList.remove("hide");
    }
    showSection();
    updateCurrentTabStyle();
}
//check show next or previous page
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