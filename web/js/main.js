
$(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
    console.log("beforeInsert");
});

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    console.log("afterInsert");
});

$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});


$(".dynamicform_wrapper").on("afterDelete", function(e) {
    console.log("Deleted item!");
});

$(".dynamicform_wrapper").on("limitReached", function(e, item) {
    alert("Limit reached");
});


$(".dynamicform_inner").on("beforeInsert", function(e, item) {
    console.log("Bag O na Insert");
});

$(".dynamicform_inner").on("afterInsert", function(e, item) {
    console.log("Na Insert");
});
$(".dynamicform_inner").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});


var checks = document.querySelectorAll("#jems");
var max = 2;
for (var i = 0; i < checks.length; i++)
  checks[i].onclick = selectiveCheck;
function selectiveCheck (event) {
  var checkedChecks = document.querySelectorAll("#jems:checked");
  if (checkedChecks.length >= max + 1){
    alert("You can only select a maximum of "+max+" checkboxes");
    return false;
  }
  
    
}