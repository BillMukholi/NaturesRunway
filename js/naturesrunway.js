if (typeof variationData !== 'undefined'){
    const bdi = document.getElementsByTagName('bdi');
    const variationFrom = document.getElementsByClassName("variations_form")[0]
    const regularPrice = document.getElementsByClassName('regular-price')[0]
    const salePrice = document.getElementsByClassName('sale-price')[0]
    const variationImg = document.getElementById("variationImg")
    setTimeout(()=>{
        regularPrice.innerText = bdi[2].innerText
        salePrice.innerText = bdi[3].innerText
    },1000)

    variationFrom.addEventListener('click',()=>{
        setTimeout(()=>{
            regularPrice.innerText = bdi[2].innerText
            salePrice.innerText = bdi[3].innerText
        },500)
        setTimeout(()=>{
            var variation_data = variationData.find(function(variation) {
                return variation.variation_id == jQuery( 'input[name="variation_id"]' ).val();
            });
            var image_url = variation_data.image_url;
            variationImg.setAttribute('src',image_url)
            
        },2000)
    })

}


const infoSection = document.getElementsByClassName('product-area-info-cont')[0]
const sticky = document.getElementsByClassName('product-area-two-cont')[0]
sticky.style.height = (infoSection.offsetHeight+100)+'px';

window.addEventListener('resize',()=>{
    sticky.style.height = infoSection.offsetHeight;
})