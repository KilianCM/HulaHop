
window.addEventListener("DOMContentLoaded", (event) => {
    checkInputWithQueryParam(window.location.search);
    filterCategory();
});

function checkInputWithQueryParam(params) {
    const urlParams = new URLSearchParams(params);
    const categories = urlParams.get("categories");

    if(categories) {
        categories.split(",").forEach(id => {
            let input = document.getElementById(id);
            input.checked = true;
        });
    }
}

function filterCategory() {
    const btnFilter = document.getElementById("button-filter");
    let categories = Array.from(document.getElementsByTagName("input"));
    btnFilter.addEventListener("click", function () {
        let route = "/showcase";
        // Get array of ids of selected inputs
        let categoriesChecked = categories.filter(input => input.checked).map(category => category.value);
        if(categoriesChecked.length !== null && categoriesChecked.length !== 0){
            if(categoriesChecked.length > 1) {
                route = "/showcase?categories=";
                categoriesChecked.forEach(data => {
                    route += data + ",";
                });
                route = route.substring(0, route.length-1);
            }
            if(categoriesChecked.length === 1) {
                route = "/showcase?categories=" + categoriesChecked[0];
            }
        }
        window.location.replace(route);
    });

}
