
window.addEventListener("DOMContentLoaded", (event) => {
    filterCategory();
});

function filterCategory() {

    const btnFilter = document.querySelector("#btnFilter");
    let category = document.getElementsByTagName("input");
    btnFilter.addEventListener("click", function () {
        let categories;
        let categoriesChecked = [];
        for(let i = 0; i < category.length; i ++) {
            if(category[i].checked) {
                categoriesChecked.push(category[i].value);
            }
        }
        if(categoriesChecked.length !== null && categoriesChecked.length !== 0){
            if(categoriesChecked.length > 1) {
                categories = "/showcase?categories=";
                categoriesChecked.forEach(data => {
                    categories += data + ",";
                });
                categories = categories.substring(0, categories.length-1);
            }
            if(categoriesChecked.length === 1) {
                categories = "/showcase?categories=" + categoriesChecked[0];
            }
        } else {
            categories = "/showcase";
        }
        window.location.replace(categories);
    });

}
