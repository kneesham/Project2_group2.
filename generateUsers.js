/********************************************************************
 * Date Created: 04/07/2020
 * Creator: Theodore Nesham
 * Version: 1.0
 * Last Modified: 04/21/2020
 *******************************************************************/

 // We are making the assumtion that there are roughly 100 races.

import cityJson from './cities.js';

const databaseObj = []
// the main object array that will hold race results, users, and events just so we can load mass amounts of data.



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
            let numRaces = Math.floor(( (i > 175 ? (Math.random() * 10000 ) : (Math.random() * i * 10)) / 100 )) ;
            let city = cities[Math.floor(Math.random() * cities.length)];
            let email = fullName.replace(" ", "") + "@" + emailExt[Math.floor(Math.random() * emailExt.length)];
            let userPassword = fullName.replace(" ", symbolList[Math.floor(Math.random() * symbolList.length)]) + symbolList[Math.floor(Math.random() * symbolList.length)];

            while (userObj.hasOwnProperty(userId)) { // loop until the uerId is not a duplicate.
                userId = Math.round(Math.random() * Math.pow(10, 9))
            }
            // push the new user object into the main userObj
            userObj.push({
                Id: userId,
                FullName: fullName,
                City: city,
                Email: email,
                UserPass: userPassword,
                NumRaces: numRaces
            });
        }
    })();
    return userObj;
}

const raceList = () => {
    // generate a random list of events all events will be before 04-01-2020!
    let raceObj = [];
    let tempRaces = [];
    (() => {
         // making var so that function scoping is involved.
        let cities = Object.keys(cityJson); // returns an array of keys
        let event_names = ["go", "Foam_Glow", "Stadium_Blitz", "Frisco_Railroad_Run"];
        let distance = ["5K", "10K", "15K", "20K", "Half-marathon", "25K", "30K", "Marathon" ];
        let associatedDistance = [3.1, 6.2, 9.3, 12.4, 13.1, 15.5, 18.6, 26.2];

        for (let i = 0; i < 200; i++) {

            let distanceIndex = Math.floor(Math.random() * distance.length);
            let raceLocation = cities[Math.floor(Math.random() * cities.length)];
            let raceType = distance[distanceIndex];
            let raceDistance = associatedDistance[distanceIndex];
            let randomYear =  ~~(Math.random() * (2020 - 2000) + 2000);
            let randomMonth =  ~~(Math.random() * (12 - 1) + 1); // 3 is because this is made in april, making every single event in the past.
            let randomDay =  ~~(Math.random() * (28 - 1) + 1);
            let eventId = ~~(Math.random() * Math.pow(10, 9));

            tempRaces.push(eventId);

            while(tempRaces.includes(eventId)) {
                // for uniqueness.
                eventId = ~~(Math.random() * Math.pow(10, 9));
            }


            let raceDate = randomYear + "-"
                          + (randomMonth < 10 ? "0": "") + randomMonth
                          + "-" + (randomDay < 10 ? "0": "") + randomDay;
            let eventName = event_names[Math.floor(Math.random() * event_names.length)]
            +  "_" + raceLocation.replace(" ", "")
            + "_" + raceType;

            raceObj.push({
                EventId: eventId,
                RaceName: eventName,
                RaceLocation: raceLocation,
                RaceDate: raceDate,
                RaceType: raceType,
                RaceDistance: raceDistance
            });
        }
    })();
    return raceObj;
};


//// BOTH OF THESE NEED TO BE CALLED BEFORE CREATING THE EVENT RESULTS
databaseObj.users = userList();
databaseObj.races = raceList();
//// BOTH OF THESE NEED TO BE CALLED BEFORE CREATING THE EVENT RESULTS

const eventResults = () => {
    let eventResObj = [];

    databaseObj.users.forEach(user => {

        let tempCompleted = [];

        for (let i = 0; i < user.NumRaces; i++) {
            // assign an event for every event a user has completed.
            let raceIndex = Math.floor(Math.random() * databaseObj.races.length);
            let resultId = databaseObj.races[raceIndex].EventId;
            let timeInMin = Math.floor(Math.random() * 9.5 * databaseObj.races[raceIndex].RaceDistance);

            while(tempCompleted.includes(resultId)){
                // get a new raceid until its not a duplicate.
                resultId = databaseObj.races[Math.floor(Math.random() * databaseObj.races.length)].EventId;
            }
            
            tempCompleted.push(resultId);
            // push the temp completed
            
            eventResObj.push({
                ResultId: resultId,
                RunnerId: user.Id,
                time: timeInMin
            });
        }
    });
    return eventResObj;
};

const getPlaceRacers = (eventResults) => {

    // sort both arrays such that they resulting id's are in order

    eventResults.sort((a, b) => {
        // sorting based on the result id itself and then by the time in minitues.
        const id1 = parseInt(a.ResultId);
        const id2 = parseInt(b.ResultId);
        return (id1 > id2 ? 1 :
            (id1 < id2) ? -1 :
                (a.time > b.time) ? 1 : -1);
    });

    let placeMarker = 1;
    for (let i = 1; i < eventResults.length; i++) {

        let timeInMin = eventResults[i - 1].time;
        let hours = Math.floor(timeInMin / 60);
        let minutes = Math.floor(timeInMin - hours * 60);
        let seconds = Math.floor(Math.random() * 60);

        if (eventResults[i - 1].ResultId === eventResults[i].ResultId) {
            //   console.log('twas true');
            eventResults[i - 1].place = placeMarker;
            eventResults[i - 1].time = (hours < 10 ? ("0" + hours ) : hours ) +  ":"
                                        + (minutes < 10 ? ("0" + minutes ) : minutes ) + ":"
                                        + (seconds < 10 ? ("0" + seconds ) : seconds );
            placeMarker++;
        }

        else {
            eventResults[i - 1].place = placeMarker;
            eventResults[i - 1].time = (hours < 10 ? ("0" + hours ) : hours ) +  ":"
                                        + (minutes < 10 ? ("0" + minutes ) : minutes ) + ":"
                                        + (seconds < 10 ? ("0" + seconds ) : seconds );
            placeMarker = 1;
        }
        if ( (i +1) === eventResults.length ){
            eventResults[i].place = placeMarker;
            eventResults[i].time = (hours < 10 ? ("0" + hours ) : hours ) +  ":"
                                        + (minutes < 10 ? ("0" + minutes ) : minutes ) + ":"
                                        + (seconds < 10 ? ("0" + seconds ) : seconds );

        }
    }

    return eventResults;
};


databaseObj.eventResults =  getPlaceRacers( eventResults() );


console.log(databaseObj);


document.getElementById("textArea").value = JSON.stringify(databaseObj.users);
document.getElementById("textArea1").value = JSON.stringify(databaseObj.eventResults);
document.getElementById("textArea2").value = JSON.stringify(databaseObj.races);


document.getElementById("myJsonForm").submit();
// fill and submit the form with the json object.



