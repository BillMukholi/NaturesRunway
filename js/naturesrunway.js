// Select all <bdi> elements in the document
const bdi = document.getElementsByTagName('bdi');
const variationFrom = document.getElementsByClassName("variations_form")[0]
const regularPrice = document.getElementsByClassName('regular-price')[0]
const salePrice = document.getElementsByClassName('sale-price')[0]
setTimeout(()=>{
    regularPrice.innerText = bdi[2].innerText
    salePrice.innerText = bdi[3].innerText
},500)


variationFrom.addEventListener('click',()=>{
    setTimeout(()=>{
        regularPrice.innerText = bdi[2].innerText
        salePrice.innerText = bdi[3].innerText
    },500)
})