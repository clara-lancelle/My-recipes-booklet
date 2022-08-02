
// hamburger menu

$("#menu-button").click(function(){
  $(this).toggleClass("active");
  $("#line-1").toggleClass("active");
  $("#line-2").toggleClass("active");
  $("#line-3").toggleClass("active");
  $("#menu").slideToggle("slow");
});


var coll = document.getElementsByClassName("btn--collapse");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var bloc__collapse = this.nextElementSibling;
    if (bloc__collapse.style.display === "block") {
      bloc__collapse.style.display = "none";
    } else {
      bloc__collapse.style.display = "block";
    }
  });
}

