"use strict";

// hamburger menu

$("#menu-button").click(function(){
  $(this).toggleClass("active");
  $("#line-1").toggleClass("active");
  $("#line-2").toggleClass("active");
  $("#line-3").toggleClass("active");
  $("#menu").slideToggle("slow");
});


// collapse btn

let coll = document.getElementsByClassName("btn--collapse");

for (let i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
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

if(dropBtn){
    function myFunction() {
        document.getElementById("filterTable").classList.toggle("show");
    }
      
      //Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            let dropdowns = document.getElementById("filterTable");
          
            for (let i = 0; i < dropdowns.length; i++) {
                let openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')){
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
}



// dropdown sort

let sortBtn = document.getElementById('sortBtn');

if(sortBtn){

    sortBtn.addEventListener('click',function(){

    let sortTable =  document.getElementById("sortTable");
    sortTable.classList.toggle("show");
  
      for (let i = 0; i < sortTable.length; i++) {
        let openDropdown = sortTable[i];
        if (openDropdown.classList.contains('show')){
            openDropdown.classList.remove('show');
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



// download extension recipe to PDF 


// tranform img to data URL 


function toDataURL(src, callback){
    let image = new Image();
    image.crossOrigin = 'Anonymous';
    image.onload = function(){
        let canvas = document.createElement('canvas');
        let context = canvas.getContext('2d');
        canvas.height = this.naturalHeight;
        canvas.width = this.naturalWidth;
        context.drawImage(this, 0, 0);
        let dataURL = canvas.toDataURL('image/jpeg');
        callback(dataURL);
    };
    image.src = src;
}

// create pdf

let pdfBtn = document.getElementById('pdfBtn');

pdfBtn.addEventListener('click', function(){
   
    toDataURL(document.getElementById('recetteImg').src,function(dataURL){
      let doc = new jsPDF();
      let specialElementHandlers = {
          '#editor': function (element, renderer) {
              return true;
          }
      };
      let recipe = $('#recipe').html();
      
      doc.fromHTML(recipe, 10, 20, {
          'width': 100,
          'elementHandlers': specialElementHandlers
          
      });
      
        doc.save('recette.pdf');
        })
        
});



/*
 
function Convert_HTML_To_PDF() {
    
    let recipe = $('#recipe').html();

    html2canvas(recipe, {
      useCORS: true,
      onrendered: function(canvas) {
        let pdf = new jsPDF('p', 'pt', 'letter');
  
        let pageHeight = 980;
        let pageWidth = 900;
        for (let i = 0; i <= elementHTML.clientHeight / pageHeight; i++) {
          let srcImg = canvas;
          let sX = 0;
          let sY = pageHeight * i; // start 1 pageHeight down for every new page
          let sWidth = pageWidth;
          let sHeight = pageHeight;
          let dX = 0;
          let dY = 0;
          let dWidth = pageWidth;
          let dHeight = pageHeight;
  
          window.onePageCanvas = document.createElement("canvas");
          onePageCanvas.setAttribute('width', pageWidth);
          onePageCanvas.setAttribute('height', pageHeight);
          let ctx = onePageCanvas.getContext('2d');
          ctx.drawImage(srcImg, sX, sY, sWidth, sHeight, dX, dY, dWidth, dHeight);
  
          let canvasDataURL = onePageCanvas.toDataURL("image/png", 1.0);
          let width = onePageCanvas.width;
          let height = onePageCanvas.clientHeight;
  
          if (i > 0) // if we're on anything other than the first page, add another page
            pdf.addPage(612, 864); // 8.5" x 12" in pts (inches*72)
  
          pdf.setPage(i + 1); // now we declare that we're working on that page
          pdf.addImage(canvasDataURL, 'PNG', 20, 40, (width * .62), (height * .62)); // add content to the page
        }
              
        // Save the PDF
        pdf.save('document.pdf');
      }
    });
  }

  pdfBtn.addEventListener('click',Convert_HTML_To_PDF());
  */
/*
let pdfBtn = document.getElementById('pdfBtn');

pdfBtn.addEventListener('click', function converHTMLFileToPDF() {
        const { jsPDF } = window.jspdf;
        let doc = new jsPDF();
        let specialElementHandlers = {
            '#editor': function (element, renderer) {
                return true;
            }
        };

        let pdfjs = document.querySelector('#recipe');

        // Convert HTML to PDF in JavaScript
        doc.html(pdfjs, {
        callback: function(doc) {
            doc.save("recette.pdf");
        },
        x: 10,
        y: 10,
        'elementHandlers': specialElementHandlers,
        'width': '100'
        });
    }
);
*/