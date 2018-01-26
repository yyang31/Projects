// Constructor for User object
function User(firstName, lastName, email, password){
    this.firstName = firstName;
    this.lastName = lastName;
    this.email = email;
    this.password = password;
}

// reset the user first name
User.prototype.setFirstName=function(firstName){
    this.firstName = firstName;
};

// return the user first name
User.prototype.getFirstName=function(){
    return this.firstName;
};

// reset the user last name
User.prototype.setLastName=function(lastName){
    this.lastName = lastName;
};

// return the user last name
User.prototype.getLastName=function(){
    return this.lastName;
};

// reset the user email
User.prototype.setEmail=function(email){
    this.email = email;
};

// return the user email
User.prototype.getEmail=function(){
    return this.email;
};

// reset the user password
User.prototype.setPassword=function(password){
    this.password = password;
};

// validate user password
User.prototype.checkPassword=function(password){
    if(this.password == password){return true;}
    else{return false;}
};