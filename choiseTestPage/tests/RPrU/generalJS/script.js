function rpru(X, Y, sizeCell, numberCellSize, widthTable, leftTable, topTable, leftStarRate, topStarRate, leftButton, topButton, testNumber, exercise) {
    // let X = 5, Y = 5;

    function createBlock() {
        let mainField = document.getElementById("mainField");
        let boundingClient = mainField.getBoundingClientRect().top; // при приближении начинает плющить
        mainField.style.cssText = 'width: '+ ((X * sizeCell) - 2) + "px" +'; height: '+ ((Y * sizeCell) - 2) + "px" +'; border: 4px solid black; display: inline-block;';
        for(let numberY = 0; numberY < Y; numberY++) {
            for(let numberX = 0; numberX < X; numberX++) {
                elementNumber = numberY * X + numberX + 1;
                mainField.innerHTML += '<div class="block'+ elementNumber + '" id="block'+ elementNumber + '"> <h'+ numberCellSize +' id="h2_'+ elementNumber + '" class="h2_'+ elementNumber + '">'+ elementNumber +'</h'+ numberCellSize +'>  </div>';
                document.getElementById('block'+ elementNumber + '').style.cssText = 'height: '+ sizeCell +'px; width: '+ sizeCell +'px; position: absolute; top: '+ (boundingClient + 2 + parseInt(numberY * sizeCell)) + "px" +'; left: '+ (10 + parseInt(numberX * sizeCell)) + "px" +'; border: 1px dashed black;'; 
            
            
                // window.addEventListener('resize', function() { //
                //     boundingClient = mainField.getBoundingClientRect().top;
                //     let elementNumberCopy = numberY * X + numberX + 1;
                //     document.getElementById('block'+ elementNumberCopy + '').style.top = ''+ (boundingClient + 2 + parseInt(numberY * sizeCell)) + "px" +'';  
                // }, true); // тоже решение стремное


                document.getElementById('h2_'+ elementNumber + '').style.cssText = "margin-left: 10px";
            }
        }
    }
    createBlock();
    let selectedElementCopy = 0;
    function DragAndDrop(thisElement) {
        
        let selectedElement = document.getElementById(thisElement.id);
        selectedElement.ondragstart = function() {
            return false;
        };
        selectedElementCopy = selectedElement.cloneNode(true);
        selectedElementCopy.addEventListener("mousedown", function() {
            DragAndDrop(this);    
        });


        selectedElement.style.cssText = "position: absolute; zIndex: 1000";
        // selectedElement.style.position = 'absolute';
        // selectedElement.style.zIndex = 1000;
        document.body.append(selectedElement);

        moveAt(event.pageX, event.pageY); //не пойму что тут происходит..
    
        function moveAt(pageX, pageY) {
            selectedElement.style.left = pageX - selectedElement.offsetWidth / 2 + 'px';
            selectedElement.style.top = pageY - selectedElement.offsetHeight / 2 + 'px';
            // document.body.addEventListener('mouseleave', (event) => {
            //     // console.log(localFlag);
            //     // thisElement.remove();
            // });
        }
    
        function onMouseMove(event) {
            moveAt(event.pageX, event.pageY);
            if(event.pageX < 0 || event.pageX > window.innerWidth || event.pageY < 0 || event.pageY > window.innerHeight) {
                thisElement.remove();
                // console.log("popalsa");
            }
            // console.log(event.pageX - selectedElement.offsetHeight / 2 < 0, event.pageY - selectedElement.offsetWidth / 2 < 0);
            // console.log(window.innerWidth, window.innerHeight)
            // console.log(event.pageX, event.pageY);
        }
    
        document.addEventListener('mousemove', onMouseMove);
    
        selectedElement.onmouseup = function(pageX) {
            document.removeEventListener('mousemove', onMouseMove);
            selectedElement.onmouseup = null;
            
            let xCordinate = Math.round((pageX.clientX - mainField.offsetLeft + selectedElement.offsetWidth / 2) / selectedElement.offsetWidth);
            let yCordinate = Math.round((pageX.clientY - mainField.offsetTop + selectedElement.offsetHeight / 2) / selectedElement.offsetHeight);

            if(xCordinate <= X && xCordinate > 0 && yCordinate <= Y && yCordinate > 0) {    // тут менял, если вдруг баги будут смотреть сюда
                // console.log(xCordinate, yCordinate, X, Y)
                // console.log(event.pageX, event.pageY);
                document.getElementById("block" + ((yCordinate - 1) * X + xCordinate).toString()).appendChild(selectedElement);
                selectedElement.style.cssText = "position: absolute; left: 0; top: 0;";

                let newID = (selectedElement.id + "_" + ((yCordinate - 1) * X + xCordinate).toString()).split("_");
                selectedElement.id = newID[0] + "_" + newID[newID.length - 1];
            
                document.getElementById("h2_" + ((yCordinate - 1) * X + xCordinate).toString()).style.cssText= "position: relative; left: 10px";

                let blockChild = document.querySelectorAll('div.block' + ((yCordinate - 1) * X + xCordinate).toString() + ' > div');
                if(blockChild.length > 1) blockChild[0].remove();
            
            }
            else thisElement.remove(); 
            
            
        };
        copyElement();
    }


    function copyElement() {
        let tableLength = document.querySelectorAll("div.schemaElementTable > div").length;
        for(let i = 1; i < tableLength + 1; i++) {
            if(document.getElementById("table"+ i +"").querySelector("#number"+ i +"") === null) {
                document.getElementById("table"+ i +"").appendChild(selectedElementCopy);
            }
        }
    }


    fetch("../generalPHP/file.txt").then(function(response) {
        response.text().then(function(read) {
            numberFilesInFolders(read);
        });
    });




    function numberFilesInFolders(amountImg) {

        for(let i = 1; i < parseInt(amountImg) + 1; i++) {
            let my_img = document.createElement("img");
            let my_div = document.createElement("div");
            let table = document.createElement("div");
            my_img.src = "../img/element"+ i +".png";
            my_img.style.cssText="width: "+ sizeCell +"px; height: "+ sizeCell +"px;" 
            my_div.id = "number"+ i +"";
            my_div.style.cssText = "display: inline-block;" 

            my_div.addEventListener("mousedown", function() {
                DragAndDrop(this);    
            });

            table.id = "table"+ i +"";
            table.style.cssText = "display: inline-block; margin: 5px 5px 5px 5px;"
            let schemaElementTable = document.getElementById("schemaElementTable");
            schemaElementTable.appendChild(table).appendChild(my_div).appendChild(my_img);
            schemaElementTable.style.cssText="width: "+ widthTable +"px; left: "+ leftTable +"px; top: "+ topTable +"px; height: auto; position: absolute; border: 4px solid black; background-color: rgb(194, 234, 247);"
        } 
    }





    let answerObj = [];

    function userAnswer() {
    
        let numberOfCells = document.querySelectorAll("div.mainField > div").length;
        for(let i = 1; i < numberOfCells + 1; i++) {
            let cellContent = document.querySelectorAll("div."+ document.querySelectorAll("div.mainField > div")[i - 1].id +" > div");
            if(cellContent.length > 0) {
                let stringOfValidValues = cellContent[0].id.split("_")[0].replace(/[a-zа-яё]/gi, '');
                answerObj.push(stringOfValidValues);
            }
            else {
                let blankImage = document.createElement("img");
                blankImage.src = "../img/elementEmpty.png";
                blankImage.id = "tytZanyato"; 
                blankImage.style.cssText = "position: absolute; z-index: -1000;";

                if(document.getElementById('h2_'+ i + '') !== null) {
                    document.getElementById('h2_'+ i + '').remove();
                    document.getElementById("block"+ i +"").appendChild(blankImage);
                }
            }

            let emptyCell = document.querySelectorAll("div."+ document.querySelectorAll("div.mainField > div")[i - 1].id +" > #tytZanyato");
            if(emptyCell.length > 0) answerObj.push("");      
        }
    }
        
    function schemaValidation(good, bad) {
        // for(let i = 0; i < good.length; i++) {
        //     let checkMark = document.createElement("img");
        //     checkMark.src = "../img/right.png";
        //     checkMark.style.cssText = "position: absolute;";
        //     document.getElementById("block"+ good[i] +"").appendChild(checkMark);
        // }
        
        // for(let i = 0; i < bad.length; i++) {
        //     let cross = document.createElement("img");
        //     cross.src = "../img/incorrect.png";
        //     cross.style.cssText = "position: absolute;";
        //     document.getElementById("block"+ bad[i]+"").appendChild(cross);
        // }
    }





    async function SendFormSecond(element) {
        userAnswer();
        element.preventDefault();
        let objToServer = new FormData(document.getElementById('form'));
        let answerJSON = JSON.stringify([answerObj, testNumber]);
        objToServer.append('answerJSON', answerJSON);
    
        try {
            timerRemove();
            const response = await fetch('../generalPHP/form.php', {
                method: 'POST',
                body: objToServer
            });
            let json = await response.json();
           
            if(json[4] >= 3) {
                alert("попытки кончились");
                location.href = '../../../choiseTestPage.php';
            }
            else {
                schemaValidation(json[1], json[2]);
                marking(json[3]);
            }
            console.log(json[4])
              
        } 
        catch (error) {
            console.error('Ошибка:', error);
        }
    }
    form.onsubmit = SendFormSecond;



    // function sizeSchemaElementTable() { 
    //     let boundingClient = document.getElementById("mainField").getBoundingClientRect().top + topTable;
    //     document.getElementById("schemaElementTable").style.top=""+boundingClient+"px";
    //     window.addEventListener('resize', function() {
    //         boundingClient = document.getElementById("mainField").getBoundingClientRect().top + topTable;
    //         document.getElementById("schemaElementTable").style.top=""+boundingClient+"px";
    //     }, true);
    
    // }
    // sizeSchemaElementTable();



    function marking(markFromPHP) {
        let markToDisplay = document.createElement("div");
        let leftMark = leftStarRate + 500;
        markToDisplay.style.cssText = "position: absolute; left: "+ leftMark +"px; top: "+ topStarRate +"px";
        markToDisplay.id = "mark";
        document.body.append(markToDisplay);
        let markValue = document.createElement("h1");
        markValue.append(""+ parseInt(markFromPHP * 100) / 100 +"/10");
        document.getElementById("mark").appendChild(markValue);
        document.getElementById("starRate").setAttribute("width", 500)
        document.getElementById("fillingPercentX").setAttribute("x", ""+ markFromPHP * 10+ "%")
    }

    function otherElemPosition() {
        document.getElementById("starRate").style.cssText="position: absolute; left: "+ leftStarRate +"px; top: "+ topStarRate +"px";
        document.getElementById("schemaValidation").style.cssText="position: absolute; left: "+ leftButton +"px; top: "+ topButton +"px";
        document.getElementById("exercise").append(exercise)
    }
    otherElemPosition();



    let time = 500;
    // function timer() {
        
        const timer = async () => { 
             
            let seconds = time;
            let delay = 1; 

            let timerWrapper = document.getElementById("timer");
            timerWrapper.style.cssText="position: absolute; top: 5%; left: 90%; width: 100px; height: 30px";

            for(let i = 0; i <= time; i++) { 
                await new Promise(res => setTimeout(() => {
                    delay = 1000;
                    let minutes =  Math.floor(seconds / 60);
                    if(seconds % 60 < 10) timerWrapper.innerHTML = ""+ minutes +":0"+ seconds % 60 +"";
                    else timerWrapper.innerHTML = ""+ minutes +":"+ seconds % 60 +"";
                    
                    if(seconds === 0 && time !== -1) {
                        let button = document.getElementById("schemaValidation");
                        button.click();
                    }
                    if(seconds < 60 && seconds >= 10) timerWrapper.style.color = "orange";
                    if(seconds < 10) timerWrapper.style.color = "red";
                    timerWrapper.style.fontSize = "50";
                    seconds -= 1;
                    res();  
                }, delay));
            }
        };
        timer();
        

        
        function timerRemove() {
            document.getElementById("schemaValidation").remove();
            document.getElementById("timer").remove(); 
            time = -1;
        }
      
       

    // }
    // timer();



    // function timeLimit() {
    //     document.getElementById("schemaValidation").click();
    // }
    // setTimeout(timeLimit, 60000);
}