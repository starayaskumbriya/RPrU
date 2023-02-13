<?php include_once 'accessCheck.php'; ?>

<html>
<head>
    <meta charset="UTF-8">
</head>
<body>


    <form id="topicAndNumber" action="accessCheck.php" method="post"> 
        
        <div class="wrapper" id="wrapper1">
            <input type="button" class="button" id="button1" onclick="uncover(this);">
            <p class="topicName">радиоприемные устройства</p>
            <div class="topic" id="topic1"></div>
        </div>

        <div class="wrapper" id="wrapper2">
            <input type="button" class="button" id="button2" onclick="uncover(this);">
            <p class="topicName">согласующиеся цепи</p>
            <div class="topic" id="topic2"></div>
        </div>

        <div class="wrapper" id="wrapper3">
            <input type="button" class="button" id="button3" onclick="uncover(this);">
            <p class="topicName">усилители радиосигналов</p>
            <div class="topic" id="topic3"></div>
        </div>
    
        <div class="wrapper" id="wrapper4">
            <input type="button" class="button" id="button4" onclick="uncover(this);">
            <p class="topicName">преобразователи частоты</p>
            <div class="topic" id="topic4"></div>
        </div>

        <div class="wrapper" id="wrapper5">
            <input type="button" class="button" id="button5" onclick="uncover(this);">
            <p class="topicName">детекторы</p>
            <div class="topic" id="topic5"></div>
        </div>
    </form> 




    <script>
        let numberAttempts = 3;
        let topicAndNumberArr = [];

        function testNumber(number) {
            topicAndNumberArr.push(number.id);
        }



        function generateButton(amountButton, topicNumber, topicName, value) {
            let sqlTablePhp = '<?= (json_encode($row)) ?>';
            let testsNotPassed = 0;

            for(let i = 1; i < amountButton + 1; i++) {               

                let sqlTableJs = JSON.parse(sqlTablePhp)[topicName + i];
                let markForInnerHTML = [];
                if(sqlTableJs === null) {
                    sqlTableJs = 0;
                    testsNotPassed++  //тут считаем количество тестов которые осталось пройти по признаку проходился ли тест когда либо
                }
                else {

                    let markArr = sqlTableJs.split(";");
                    let bestMark = 0;
                    let markSum = 0;
                    for(let i = 0; i < markArr.length - 1; i++) {
                        if(bestMark < markArr[i]) bestMark = markArr[i];
                        markSum += Number(markArr[i]);
                    }
                    let mediumMark = markSum / (markArr.length - 1); 
    
                    markForInnerHTML.push(parseInt(bestMark * 100) / 100, parseInt(mediumMark * 100) / 100);


                    sqlTableJs = sqlTableJs.replace(/[^;]/g, '').length;

                    

                }


                let buttonWrapper = document.createElement("div");
                buttonWrapper.id = "buttonWrapper" + i;
                let button = document.createElement("input");
                button.style.cssText = "display: inline-block; margin-bottom: 5px; margin-left: 5%; border: 0px; padding-left: 0px; background: none; text-decoration: underline; cursor: pointer;"
                button.id = topicName + i;
                button.value = value+ " "+ i;
                button.type = "submit";
                button.addEventListener("click", function() {
                    testNumber(this);
                });

          
                
                let restOfAttempts = document.createElement("div");
                restOfAttempts.id = topicName + i;
                restOfAttempts.style.cssText = "display: inline-block; margin-left: 5%";
                restOfAttempts.innerHTML = "осталось попыток " + (numberAttempts - sqlTableJs);

                


                let topic = document.getElementById("topic"+ topicNumber +"");
                topic.appendChild(buttonWrapper).appendChild(button);
                buttonWrapper.appendChild(restOfAttempts);



                if(sqlTableJs !== 0) {
                    let bestMarkWrapper = document.createElement("div"), mediumMarkWrapper = document.createElement("div");

                    bestMarkWrapper.style.cssText = "display: inline-block; margin-left: 5%";
                    bestMarkWrapper.innerHTML = "лучшая оценка " + markForInnerHTML[0];
                    buttonWrapper.appendChild(bestMarkWrapper), 
                    
                    mediumMarkWrapper.style.cssText = "display: inline-block; margin-left: 5%";
                    mediumMarkWrapper.innerHTML = "средняя оценка " + markForInnerHTML[1];
                    buttonWrapper.appendChild(mediumMarkWrapper);
                    
                }
                
            }  
            
            

            let topicWrapper = document.getElementById("wrapper"+ topicNumber +"");
            let testsNotPassedWrapper = document.createElement("div");
            testsNotPassedWrapper.id = "testsNotPassedWrapper"+ topicNumber +"";
            testsNotPassedWrapper.style.cssText = "display: inline-block; margin-left: 25%;"
            testsNotPassedWrapper.innerHTML = "осталось пройти тестов: " + testsNotPassed;
            topicWrapper.appendChild(testsNotPassedWrapper);
        }


        function uncover(numberButton) { 
            let id = numberButton.id.replace(/[a-zа-яё]/gi, '');
            let elementId = "topic" + id;
            if(window.getComputedStyle(document.getElementById(elementId)).display === "none") {
                document.getElementById(elementId).style.display="block";
                document.getElementById("testsNotPassedWrapper"+ id +"").style.display="none";
            }
            else {
                document.getElementById(elementId).style.display="none";
                document.getElementById("testsNotPassedWrapper"+ id +"").style.display="inline-block";
            }
        }




        async function SendtopicAndNumber(element) {

            element.preventDefault();
            let topicAndNumber = new FormData(document.getElementById('topicAndNumber'));
            let topicAndNumberJSON = JSON.stringify(topicAndNumberArr);
            topicAndNumber.append('topicAndNumberJSON', topicAndNumberJSON);

            try {
                const response = await fetch('accessCheck.php', {
                    method: 'POST',
                    body: topicAndNumber
                });
                let json = await response.json();
                //document.getElementById("restOfAttempts").value = numberAttempts - json[1];
                
                if(json[1] < numberAttempts) {
                    let type = json[0].replace(/[^a-zа-яё]/gi, '');
                    if(type === "RPrU") location.href = "tests/RPrU/RPrU1-10/1-10.php?"+ json[0] +"";
                    if(type === "VC") location.href = "tests/SC/VC1-14/1-14.php?"+ json[0] +"";
                    if(type === "URS") location.href = 'http://www.yandex.ru/';
                    if(type === "PCH") location.href = 'http://www.yandex.ru/';
                    if(type === "detector") location.href = 'http://www.yandex.ru/';
                }
                else alert("попытки кончились");
                // console.log(json);
            } 
            catch (error) {
                console.error('Ошибка:', error);
            }
        } 
        topicAndNumber.onsubmit = SendtopicAndNumber;


        generateButton(11, 1, "RPrU", "РПрУ");
        generateButton(14, 2, "VC", "ВЦ");
        // generateButton(34, 3, "URS", "УРС");
        // generateButton(15, 4, "PCH", "ПЧ");
        // generateButton(19, 5, "detector", "Детектор");

    </script>














    <style>
        .wrapper {
            width: 100%;
            min-height: 5%;
            margin-bottom: 5px;
            border-bottom: 1px solid;
        }
        
        .button {
            display: inline-block;
            height: 50px;
            width: 50px;
            background: url("img/down.png");
            background-size: 50%;
            background-position: center;
            background-repeat: no-repeat;
            border: none;
        }
        .button:hover {
            /* border-radius: 50%; */
            background-color: lightgray;
        }

        .topicName {
            position: absolute;
            display: inline-block;
            margin-left: 1%;
        }

        .topic {
            display: none;
        }
    </style>

</body>
</html>