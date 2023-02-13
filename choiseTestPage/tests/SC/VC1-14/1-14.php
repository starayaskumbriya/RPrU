<?php include_once 'generalPHP/createTxt.php'; ?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../img/capy6.png">
    <!-- <link rel="stylesheet" href="css/style.css"> -->

</head>
<body>
    <form id="form" action="index.php" method="post">
        <h3 id="exercise">Составить схему</h3>
        <div class="mainField" id="mainField"></div>
        <div class="schemaElementTable" id="schemaElementTable"></div>
        <button type="submit" onclick="" class="schemaValidation" id="schemaValidation">проверить схему</button>
    </form>
    
    
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


    <svg id="starRate" class="starRate" width="0" height="50" >
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


    <script src="../generalJS/script.js"></script> 

    <script>
        let numberPage = window.location.search.replace(/[^0-9]/g, '');
        if(numberPage === '1') rpru(5, 5, 75, 4, 700, 400, 50, 10, 440, 950, 400, 1, " ВЦ 1 с внешнеёмкостным включением антенны и внутриёмкостным включением нагрузки");
        if(numberPage === '2') rpru(5, 5, 75, 4, 700, 400, 50, 10, 440, 950, 400, 2, " ВЦ 2 с повышенной избирательностью по ЗК с внешнеёмкостным включением антенны и внутриёмкостным включением нагрузки");
        if(numberPage === '3') rpru(5, 5, 75, 4, 700, 400, 50, 10, 440, 950, 400, 3, " ВЦ 3 с внешнеёмкостным включением антенны и автотрансформаторным включением нагрузки");
        if(numberPage === '4') rpru(5, 5, 75, 4, 700, 400, 50, 10, 440, 950, 400, 4, " ВЦ 4 с внешнеёмкостным включением антенны и трансформаторным включением нагрузки");
        if(numberPage === '5') rpru(6, 4, 75, 4, 700, 470, 50, 10, 400, 1030, 400, 5, " ВЦ 5 с внутриёмкостным включением антенны и автотрансформаторным включением нагрузки");
        if(numberPage === '6') rpru(6, 4, 75, 4, 700, 470, 50, 10, 400, 1030, 400, 6, " ВЦ 6 с внутриёмкостным включением антенны и внутриёмкостным включением нагрузки");
        if(numberPage === '7') rpru(5, 4, 75, 4, 700, 400, 50, 10, 400, 950, 400, 7, " ВЦ 7 с внутриёмкостным включением антенны и полным включением нагрузки");
        if(numberPage === '8') rpru(6, 4, 75, 4, 700, 470, 50, 10, 400, 1030, 400, 8, " ВЦ 8 с автотрансформаторным включением антенны и трансформаторным включением нагрузки");
        if(numberPage === '9') rpru(6, 3, 75, 4, 700, 470, 50, 10, 400, 1030, 400, 9, " ВЦ 9 с автотрансформаторным включением антенны и внутриемкостным включением нагрузки");
        if(numberPage === '10') rpru(5, 4, 75, 4, 700, 400, 50, 10, 400, 950, 400, 10, " ВЦ 10 с трансформаторным включением антенны и автотрансформаторным включением нагрузки");
        if(numberPage === '11') rpru(6, 3, 75, 4, 700, 470, 50, 10, 400, 1030, 400, 11, " ВЦ 11 с трансформаторным включением антенны и внутриёмкостным включением нагрузки");
        if(numberPage === '12') rpru(5, 5, 75, 4, 700, 400, 50, 10, 440, 950, 400, 12, " ВЦ 12 с полным включением нагрузки");
        if(numberPage === '13') rpru(6, 5, 75, 4, 700, 470, 50, 10, 440, 1030, 400, 13, " ВЦ 13 с автотрансформаторным включением нагрузки");
        if(numberPage === '14') rpru(7, 5, 75, 4, 700, 550, 50, 10, 440, 1110, 400, 14, " ВЦ 14 с внутриёмкостным включением нагрузки");
     
           //(X, Y, sizeCell, numberCellSize, widthTable, leftTable, topTable, leftStarRate, topStarRate leftButton, topButton, testNumber, exercise)
        // rpru(13, 3,    60,          4,            915,       10,        250,       10,           400,        780,       400,        1,      " детекторного РПрУ");
    </script>


</body>
</html>