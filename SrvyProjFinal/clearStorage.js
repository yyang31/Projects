function clearStorage(){
    if(confirm("Press 'OK' to confirm")){
        window.localStorage.clear();
        window.location.reload();
    }
}