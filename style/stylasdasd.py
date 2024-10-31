* {
    font-family: 'Trebuchet MS';
    box-sizing: border-box;
}
body {
    margin: 0;
    background-image: linear-gradient(purple, navy);
    background-attachment: fixed;
    color: white;
}
div {
    margin-top: 0.5vh;
    margin-bottom: 0.5vh;
    margin-left: 0.25%;
    margin-right: 0.25%;
    background-color: rgba(0, 0, 0, 0.6);
}
div > fieldset > legend {
    text-align: center;
    color: rgb(221, 110, 255);
    font-size: 1.6em;
}
div > fieldset {
    border: solid 2px rgb(221, 110, 255);
    position: relative;
    height: 100%;
    padding: 0;
    font-size: small;
}

#baner {
    width: 99.5%;
    height: 13vh;
    font-size: 1.7em;
    float: left;
}
#tytul {
    margin:0;
    text-align: right;
}
img{
    position: absolute;
    left:3%;
    top:4vh
}
#nawigacja {
    width: 14.5%;
    height: 84vh;
    float: left;
    box-sizing: border-box;
}
#kontent {
    padding: 0 1%;
    width: 74.5%;
    height: auto;
    min-height: 84vh;
    float: left;
    color: white;
}
#ustawienia {
    width: 9.5%;
    height: 84vh;
    float: left;
}
#administracja {
    width: 100px;
    height: 35px;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    background-color: rgb(80, 80, 80);
    position: fixed;
    bottom: -0.5vh;
    left: 50%;
    transform: translateX(-50%);
}
#administracja:hover {
    background-color: rgb(100, 100, 100);
    animation-name: animacjaAdministracja;
    animation-fill-mode: forwards;
    animation-duration: 0.3s;
}
@keyframes animacjaAdministracja {
    0% { height: 35px; }
    100% { height: 45px; }
}
a {
    color: rgb(200, 200, 200);
    text-decoration: none;
    font-size: 1.5em;
    margin-left: 13px;
}
a:hover {
    color: white;
    text-shadow: 0 0 13px white;
}
