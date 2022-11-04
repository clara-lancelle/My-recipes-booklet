"use strict";

// hamburger menu

$("#menu-button").click(function () {
    $(this).toggleClass("active");
    $("#line-1").toggleClass("active");
    $("#line-2").toggleClass("active");
    $("#line-3").toggleClass("active");
    $("#menu").slideToggle("slow");
});


// collapse btn

let coll = document.getElementsByClassName("btn--collapse");

for (let i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function () {
        this.classList.toggle("active");
        let bloc_collapse = this.nextElementSibling;
        if (bloc_collapse.style.display === "block") {
            bloc_collapse.style.display = "none";
        } else {
            bloc_collapse.style.display = "block";
        }
    });
}

// dropdown filters

let dropBtn = document.getElementById('dropBtn');

if (dropBtn) {

    let FilterTable = document.getElementById("filterTable");

    dropBtn.addEventListener('click', function () {
        FilterTable.classList.toggle("show");

        //Close the dropdown if the user clicks outside of it
        window.onclick = function (event) {
            if (!event.target.matches('#dropBtn')) {
                let dropdowns = document.getElementById("filterTable");
                if (!event.target.closest('#filterTable')) {
                    dropdowns.classList.remove('show');
                }
            }
        }
    })
}



// dropdown sort

let sortBtn = document.getElementById('sortBtn');

if (sortBtn) {

    sortBtn.addEventListener('click', function () {
        let sortTable = document.getElementById("sortTable");
        sortTable.classList.toggle("show");

        //Close the dropdown if the user clicks outside of it
        window.onclick = function (event) {
            if (!event.target.matches('#sortBtn')) {
                let sortdowns = document.getElementById("sortTable");
                if (!event.target.closest('#sortTable')) {
                    sortdowns.classList.remove('show');
                }
            }
        }
    })
}




// stop script after success 

const observer = new MutationObserver((mutations, obs) => {

    const success = document.getElementById('success_message');

    if (success) {
        let form = document.getElementById('form');
        form.classList.toggle("hide");
        obs.disconnect();
        return;
    }
});

observer.observe(document, {
    childList: true,
    subtree: true
});


