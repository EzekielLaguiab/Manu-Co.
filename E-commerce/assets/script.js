// for the navbar

// fetch(header.html)
// .then(response => {
//     if (!response.ok){
//         throw new Error('HTTP error! status: ${response.status}');
//     }
//     return response.text();
// })
// .then(data =>{
//     document.getElementById('header').innerHTML = data;
// })
// .catch(error => console.error('Error loading header:', error));


// single product change the main to small
var mainImg = document.getElementsByClassName("mainImg")[0];
var smallImg = document.getElementsByClassName("small-image");

for (let i = 0; i < smallImg.length; i++) {
    smallImg[i].onclick = function() {
        mainImg.src = smallImg[i].src;
    }
}
