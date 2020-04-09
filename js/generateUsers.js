/********************************************************************
 * Date Created: 04/07/2020
 * Creator: Theodore Nesham
 * Version: 1.0
 * Last Modified: 04/07/2020
 *******************************************************************/

import cityJson from './cities.js';

const userList = () => {
    let userObj = [];
    (() => {
         // making var so that function scoping is involved.
        let cities = Object.keys(cityJson); // returns an array of keys
        let emailExt = ["gmail.com", "hotmail.com", "live.com", "outlook.com", "mail.com", "yahoo.com"];
        let symbolList = ["\!", "@", "\%", "\_", "$", "\*"];
        let firstNames = ["Liam", "Noah", "William", "James", "Oliver", "Benjamin", "Elijah", "Lucas", "Mason", "Logan", "Alexander",
            "Emma", "Olivia", "Ava", "Isabella", "Sophia", "Charlotte", "Mia", "Amelia", "Harper", "Evelyn"];
        let lastNames = ["Smith", "Johnson", "Williams", "Jones", "Brown", "Davis", "Miller", "Wilson", "Moore", "Taylor", "Anderson",
            "Clark", "Rodriguez", "Lewis", "Lee", "Walker", "Hall", "Allen", "Young", "Hernandez", "King", "Wright",
            "Thomas", "Jackson", "White", "Harris", "Martin", "Thompson", "Garcia", "Martinez", "Robinson", "Lopez", "Hill",
            "Scott", "Green", "Adams", "Baker", "Gonzalez", "Nelson", "Carter", "Mitchell", "Perez", "Roberts", "Turner",
            "Phillips", "Campbell", "Parker", "Evans", "Edwards", "Collins"];

        // generate random data for the user's record.
        // random data is unique combinations of the above arrays.
        for (let i = 0; i < 200; i++) {
            let fullName = firstNames[Math.floor(Math.random() * firstNames.length)] + " " + lastNames[Math.floor(Math.random() * lastNames.length)];
            let userId = Math.round(Math.random() * Math.pow(10, 9)); // will be at max 9 digits long.
            let numRaces = 0;
            let city = cities[Math.floor(Math.random() * cities.length)];
            let email = fullName.replace(" ", "@") + emailExt[Math.floor(Math.random() * emailExt.length)];
            let userPassword = fullName.replace(" ", symbolList[Math.floor(Math.random() * symbolList.length)]) + symbolList[Math.floor(Math.random() * symbolList.length)];

            while (userObj.hasOwnProperty(userId)) { // loop until the uerId is not a duplicate.
                console.log("i looped")
                userId = Math.round(Math.random() * Math.pow(10, 9))
            }
            // push the new user object into the main userObj
            userObj.push({
                Id: userId,
                FullName: fullName,
                City: city,
                Email: email,
                UserPass: userPassword,
                NumRaces:numRaces
            });
            // console.log(userObj[i]);
        }
    })();
    return userObj;
}


document.getElementById("textArea").value = JSON.stringify(userList());
document.getElementById("myJsonForm").submit();
// fill and submit the form with the json object.



