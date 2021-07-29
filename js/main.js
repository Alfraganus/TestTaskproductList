/*checkbox uchun*/
$(".checkbox-menu").on("change", "input[type='checkbox']", function() {
    var value = $(this).val();

    switch (value) {
        case 'image' :
            $("table .collapsable-image").toggleClass("collapsed");
            break;
        case 'title' :
            $("table .collapsable-title").toggleClass("collapsed");
            break;
        case 'sku' :
            $("table .collapsable-sku").toggleClass("collapsed");
            break;
        case 'stock' :
            $("table .collapsable-stock").toggleClass("collapsed");
            break;
        case 'type' :
            $("table .collapsable-type").toggleClass("collapsed");
            break;
        case 'action' :
            $("table .collapsable-action").toggleClass("collapsed");
            break;
    }


    $(this).closest("li").toggleClass("active", this.checked);
});


$(".allow-focus").click(function (e) {
    e.stopPropagation();
})


$("#your_clickable_element").click(function (e) {
    e.preventDefault();
    $("table .collapsable").toggleClass("collapsed");
});