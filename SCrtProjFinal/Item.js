// constructor for item object
function Item(item_id, name, price, description, quantity, console, img_loc)
{
    this.item_id = item_id;
    this.name = name;
    this.price = price;
    this.description = description;
    this.quantity = quantity;
    this.console = console;
    this.img_loc = img_loc;
}

Item.prototype.display=function(loc)
{
    // construct the image location/source
    var img_src = "img/";
    switch (this.console){
        case 'Nintendo Switch':{
            img_src += "nintendo_switch/";
            break;
        }
            
        case 'Xbox One':{
            img_src += "xboxone/";
            break;
        }
            
        case 'PS4':{
            img_src += "ps4/";
            break;
        }
            
        default:{
            img_src += "error";
        }
    }
    this.img_loc = img_src + this.img_loc;
    
    // construct the onclick link
    var onclick_link = "showPopup('"+this.item_id+"', '"+this.name+"', '"+this.price+"', '"+this.description+"', '"+this.quantity+"', '"+this.img_loc+"')";
    
    // construct the item container
    document.getElementById(loc).innerHTML
        // div for itemCont
        +='<div class="itemCont">'
        // div for item image
        + '<div id="imgCont">'
        + '<img src="' + this.img_loc + '" id="itemImg">'
        + '</div>'
        // div for item name
        + '<div id="itemName" onclick="'+onclick_link+'">'
        + this.name
        + '</div>'
        // div for item price
        + '<div id="itemPrice">'
        + this.price
        + '</div>'
        + '</div>';
}

Item.prototype.displayCart=function(loc)
{
    // construct the onclick link
    var onclick_link = "showPopup('"+this.item_id+"', '"+this.name+"', '"+this.price+"', '"+this.description+"', '"+this.quantity+"', '"+this.img_loc+"')";
    var removeLink = "removeCartItem.php?item_id="+this.item_id;
    
    // construct the item container
    document.getElementById(loc).innerHTML
        // div for itemCont
        +='<div class="cartItemCont">'
        // div for item image
        + '<div id="cartImgCont">'
        + '<img src="' + this.img_loc + '" id="cartItemImg">'
        + '</div>'
        // div for item price
        + '<a id="cartItemDel" href="'+removeLink+'">X</a>'
        // div for item name
        + '<div id="cartItemName" onclick="'+onclick_link+'">'
        + this.name
        + '</div>'
        // div for item price
        + '<div id="cartItemPrice">'
        + this.price
        + '</div>'
        + '</div>';
}