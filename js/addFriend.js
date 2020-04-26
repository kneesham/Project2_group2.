const addFriend = (userToAdd, logedInUser) => {

    console.log(userToAdd + "logged in is:" +  logedInUser);

    let http = new XMLHttpRequest();
    http.open("POST", "../php/addFriend.php", true);
    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    let params = "userToAdd=" + userToAdd + "&logedInUser=" + logedInUser; 
    http.send(params);
    http.onload = () => {
        alert(http.responseText);
    }
}