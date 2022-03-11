class product{

    constructor(productId, name, cover, price){
        this.productId = productId;
        this.name = name;
        this.cover = cover;
        this.price = price;
    }


    get_productId(){
        this.productId = document.getElementById('productId').addEventListener('onchange', function(){
            return this.productId.val;
        }, true);
        
    }


    get_name(){
        this.name = document.getElementById('name').addEventListener('onchange', function(){
            return this.name.val;
        }, true);
        
    }

    get_cover(){
        this.cover = document.getElementById('cover').addEventListener('onchange', function(){
            return this.cover.val;
        }, true);
    }

    get_price(){
        this.price = document.getElementById('price').addEventListener('onchange', function(){
            return this.price.val;
        }, true);
    }


    get_product(){

        return {
            'productId': this.get_productId(),
            'name': this.get_name(),
            'cover': this.get_cover(),
            'price': this.get_price()
        }
    }
}