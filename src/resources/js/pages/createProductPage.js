const selectCategory = document.querySelector('.selected-category');

selectCategory.addEventListener('change', (event) => {
    loadProductCategoryProperties(event.target.value);
});


function loadProductCategoryProperties(id) {
    selectCategory.setAttribute('disabled', true);

    fetch(`/admin/catalog/categories/${id}/properties`)
        .then(res => res.json())
        .then((res) => {
            selectCategory.removeAttribute('disabled');
            updateCategory(res);
        });
}


function updateCategory(data) {
    const container = document.querySelector('.container-category-property');
    const properties = data.properties;

    if (!properties.length) {
        return;
    }

    while (container.firstChild) {
        container.removeChild(container.lastChild);
    }

    let stringHtmlParents = '';



}
