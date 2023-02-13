<?php include_once 'createTxt.php'; ?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../img/capy6.png">
    <!-- <link rel="stylesheet" href="css/style.css"> -->

</head>
<body>
    <form id="form" action="index.php" method="post">
        <h3>Составить функциональную схему РПрУ с асинхронным прямым преобразованием</h3>
        <div class="mainField" id="mainField"></div>
        <div class="schemaElementTable" id="schemaElementTable"></div>
        <button type="submit" onclick="" class="schemaValidation">проверить схему</button>
    </form>
    
    
    <!-- <script src="../generalJS/script.js"></script> -->

    <script>
        function rpru(X, Y, sizeCellGLOBAL, numberCellSizeGLOBAL, widthTable, leftTable, topTable, testNumber) {
    // let X = 5, Y = 5;

    function createBlock() {
        let mainField = document.getElementById("mainField");
        let boundingClient = mainField.getBoundingClientRect().top; // при приближении начинает плющить
        mainField.style.cssText = 'width: '+ ((X * sizeCellGLOBAL) - 2) + "px" +'; height: '+ ((Y * sizeCellGLOBAL) - 2) + "px" +'; border: 4px solid black; display: inline-block;';
        for(let numberY = 0; numberY < Y; numberY++) {
            for(let numberX = 0; numberX < X; numberX++) {
                elementNumber = numberY * X + numberX + 1;
                mainField.innerHTML += '<div class="block'+ elementNumber + '" id="block'+ elementNumber + '"> <h'+ numberCellSizeGLOBAL +' id="h2_'+ elementNumber + '" class="h2_'+ elementNumber + '">'+ elementNumber +'</h'+ numberCellSizeGLOBAL +'>  </div>';
                document.getElementById('block'+ elementNumber + '').style.cssText = 'height: '+ sizeCellGLOBAL +'px; width: '+ sizeCellGLOBAL +'px; position: absolute; top: '+ (boundingClient + 2 + parseInt(numberY * sizeCellGLOBAL)) + "px" +'; left: '+ (10 + parseInt(numberX * sizeCellGLOBAL)) + "px" +'; border: 1px dashed black;'; 
            
            
                window.addEventListener('resize', function() { //
                    boundingClient = mainField.getBoundingClientRect().top;
                    let elementNumberCopy = numberY * X + numberX + 1;
                    document.getElementById('block'+ elementNumberCopy + '').style.top = ''+ (boundingClient + 2 + parseInt(numberY * sizeCellGLOBAL)) + "px" +'';  
                }, true); // тоже решение стремное


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

        selectedElement.style.position = 'absolute';
        selectedElement.style.zIndex = 1000;
        document.body.append(selectedElement);

        moveAt(event.pageX, event.pageY); //не пойму что тут происходит..
    
        function moveAt(pageX, pageY) {
            selectedElement.style.left = pageX - selectedElement.offsetWidth / 2 + 'px';
            selectedElement.style.top = pageY - selectedElement.offsetHeight / 2 + 'px';
        }
    
        function onMouseMove(event) {
            moveAt(event.pageX, event.pageY);
        }
    
        document.addEventListener('mousemove', onMouseMove);
    
        selectedElement.onmouseup = function(pageX) {
            document.removeEventListener('mousemove', onMouseMove);
            selectedElement.onmouseup = null;
            
            let xCordinate = Math.round((pageX.clientX - mainField.offsetLeft + selectedElement.offsetWidth / 2) / selectedElement.offsetWidth);
            let yCordinate = Math.round((pageX.clientY - mainField.offsetTop + selectedElement.offsetHeight / 2) / selectedElement.offsetHeight);
    
            if(xCordinate <= X && yCordinate <= Y) {
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



    fetch("file.txt").then(function(response) {
        response.text().then(function(read) {
            numberFilesInFolders(read);
        });
    });




    function numberFilesInFolders(amountImg) {

        for(let i = 1; i < parseInt(amountImg) + 1; i++) {
            let my_img = document.createElement("img");
            let my_div = document.createElement("div");
            let table = document.createElement("div");
            my_img.src = "imgRPrU11/element"+ i +".png";
            my_img.style.cssText="width: "+ sizeCellGLOBAL +"px; height: "+ sizeCellGLOBAL +"px;" 
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
        for(let i = 0; i < good.length; i++) {
            let checkMark = document.createElement("img");
            checkMark.src = "../img/right.png";
            checkMark.style.cssText = "position: absolute;";
            document.getElementById("block"+ good[i] +"").appendChild(checkMark);
        }
        for(let i = 0; i < bad.length; i++) {
            let cross = document.createElement("img");
            cross.src = "../img/incorrect.png";
            cross.style.cssText = "position: absolute;";
            document.getElementById("block"+ bad[i]+"").appendChild(cross);
        }
    }


    async function SendFormSecond(element) {
        userAnswer();
        element.preventDefault();
        let objToServer = new FormData(document.getElementById('form'));
        let answerJSON = JSON.stringify([answerObj, testNumber]);
        objToServer.append('answerJSON', answerJSON);
    
        try {
            const response = await fetch('../generalPHP/form.php', {
            method: 'POST',
            body: objToServer
            });
            let json = await response.json();
            schemaValidation(json[1], json[2]);
            marking(json[3]);
            console.log(json[4]);
        } 
        catch (error) {
            console.error('Ошибка:', error);
        }
    }
    form.onsubmit = SendFormSecond;



    function sizeSchemaElementTable() { // кринж
        let boundingClient = document.getElementById("mainField").getBoundingClientRect().top + topTable;
        document.getElementById("schemaElementTable").style.top=""+boundingClient+"px";
        window.addEventListener('resize', function() {
            boundingClient = document.getElementById("mainField").getBoundingClientRect().top + topTable;
            document.getElementById("schemaElementTable").style.top=""+boundingClient+"px";
        }, true);
    
    }
    sizeSchemaElementTable();




    function marking(markFromPHP) {
        let markToDisplay = document.createElement("div");
        markToDisplay.style.display = "inline-block";
        markToDisplay.id = "mark";
        document.body.append(markToDisplay);
        let markValue = document.createElement("h1");
        markValue.append(""+ parseInt(markFromPHP * 100) / 100 +"/10");
        document.getElementById("mark").appendChild(markValue);
        document.getElementById("starRate").setAttribute("width", 500)
        document.getElementById("fillingPercentX").setAttribute("x", ""+ markFromPHP * 10+ "%")
    }

}
        rpru(13, 5, 60, 4, 975, 10, 500, 11);
    </script>


    <style>


.schemaValidation {
    height: 75px;
    width: 150px;
    border-radius: 20px;
    font-size: 18px;
    font-weight: 600;
}
.schemaValidation:hover {
    background-color: rgb(186, 184, 184);
}
    </style>


    <svg id = "starRate" width="0" height="50" >
        <defs>
            <mask id="perc">
                <rect x="0" y="0" width="100%" height="100%" fill="white" /> 
                <rect id="fillingPercentX" x="0" y="0" width="100%" height="100%" fill="black" />
            </mask>
            
            <symbol viewBox="0 0 32 32" id="star">
                <path d="M31.547 12a.848.848 0 00-.677-.577l-9.427-1.376-4.224-8.532a.847.847 0 00-1.516 0l-4.218 8.534-9.427 1.355a.847.847 0 00-.467 1.467l6.823 6.664-1.612 9.375a.847.847 0 001.23.893l8.428-4.434 8.432 4.432a.847.847 0 001.229-.894l-1.615-9.373 6.822-6.665a.845.845 0 00.214-.869z" />
            </symbol>
            <symbol viewBox="0 0 160 32" id="stars">
                <use xlink:href="#star" x="-144" y="0"></use>
                <use xlink:href="#star" x="-112" y="0"></use>
                <use xlink:href="#star" x="-80" y="0"></use>
                <use xlink:href="#star" x="-48" y="0"></use>
                <use xlink:href="#star" x="-16" y="0"></use>
                <use xlink:href="#star" x="16" y="0"></use>
                <use xlink:href="#star" x="48" y="0"></use>
                <use xlink:href="#star" x="80" y="0"></use>
                <use xlink:href="#star" x="112" y="0"></use>
                <use xlink:href="#star" x="144" y="0"></use>
            </symbol>
        </defs>
        
        <use xlink:href="#stars" fill="#ffbe00" stroke="black" mask="url(#perc)"></use> 
        <use xlink:href="#stars" fill="none" stroke="black"></use>
    </svg>


</body>
</html>