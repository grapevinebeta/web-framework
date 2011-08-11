<!DOCTYPE html PUBLIC
    "-//W3C//DTD XHTML 1.1 plus MathML 2.0 plus SVG 1.1//EN"
    "http://www.w3.org/2002/04/xhtml-math-svg/xhtml-math-svg.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Grapevine Export Document</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <style type="text/css">
      /*resets from YUI*/
      body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td {margin:0; padding:0;}
      table {border-collapse:collapse; border-spacing:0;}
      fieldset,img {border:0;}
      address,caption,cite,code,dfn,em,strong,th,var {font-style:normal; font-weight:normal;}
      ol,ul {list-style:none;}
      caption,th {text-align:left;}
      h1,h2,h3,h4,h5,h6 {font-size:100%; font-weight:normal;}
      q:before,q:after {content:;}
      abbr,acronym { border:0;}

      /* setup the page */
      @page { margin: 30px; background: #ffffff; }
      /* setup the footer */
      @page { @bottom { content: flow(foot); } }
      #footer { flow: static(foot); }

      /* some useful defaults */
      th, td, caption { padding: 4px 10px 4px 5px; }

      /* useful utility */
      .clear { clear:both; }

      /* layout */
      #container { font-family: Arial; font-size: 11pt; color: #000; position: relative; }

      /* footer shenanigans! */
      #footer { text-align: center; display: block; }

      /* hack around the way prince handles the footer */
      #footer #contain { display: inline-block; width: 700px; height: 60px; }
      /* end hack */



table thead tr th, table tfoot tr th {
    background-color: #EFDFEF;
    color: #000;
    font-weight:bold;
}

tr.even {
   background-color: #EFDFEF; 
}

table th, table td {
    border-collapse: collapse;
    border-color: gray;
    border-style: solid;
    border-width: 1px;
    padding: 7px;
}

td.col-status {
    width: 40px;
}
td.col-rating {
    width: 80px;
}

table {
    border: 0 solid gray;
    border-collapse: collapse;
    border-radius: 0 0 9px 9px;
}

tfoot tr th {
    background-color: #EFDFEF;
}

.block {
    
    width:50%;
}

.box-container-right {
    float:right;

}

.clear {
    clear:both;
}

.box-container-left {
    float:left;
}

.block2 {
    float:none;
    width:100%;
    clear:both;
}

.block .inner, .block2 .inner {
    margin:10px;
}

.wide {
    width:100%;
}

#page {

margin-top:20px;

}

h2 
{

margin-bottom:10px;

}

img {
    
prince-image-resolution: 96dpi;        /* 1 image pixel maps to 1px unit */
    
}

#box-ogsi-current {
    border-top: 1px solid #000;
    background: #E7E4EF;
}

#box-ogsi td:nth-child(4n) { width: 35%;}
#box-ogsi {
    border: 1px solid #000;
}

#box-ogsi table th, #box-ogsi table td {
    border: none;
    vertical-align: middle;
}

    
    .ogsi-score-ogsi {
        padding: 5px 0px 0px;
        font-size: 20px;
        text-align: center;
    }
    .ogsi-rating-rating {
        padding: 5px 0px 0px;
        font-size: 20px;
        text-align: center;
    }
    .ogsi-reviews-reviews {
        padding: 5px 0px 0px;
        font-size: 20px;
        text-align: center;
    }
    
    .ogsi-score-value {
        padding: 0px;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        line-height: 100%;
    }
    
    .ogsi-rating-value {
        padding: 0px;
        font-size: 31px;
        font-weight: bold;
        text-align: center;
        line-height: 100%;
    }

    .ogsi-reviews {
        height: 101px;
    }
    
    .ogsi-reviews-value {
        padding: 0px;
        font-size: 31px;
        font-weight: bold;
        text-align: center;
        line-height: 100%;
    }
    
    .change-arrow {
        display: inline-block;
        width: 15px;
        height: 14px;
        vertical-align: middle;
        background-repeat: no-repeat;
    }
    
    .change-arrow.positive {
        background-image: url(http://staging.pickgrapevine.com/images/icons/arrow-up.png);
    }

    .change-arrow.negative {
        background-image: url(http://staging.pickgrapevine.com/images/icons/arrow-down.png);
    }
    
    .ogsi-rating .ogsi-rating-stars-off {
        display:none;
    }
    .ogsi-rating .ogsi-rating-stars-on {
        display:none;
    }
    
    .change-value {
        font-size: 14px;
    }
    
    .box-ogsi-review-distribution .title {
        text-align: center;
        padding: 5px;
        background-color: #D1CDDD;
        color: white;
        font-weight: normal;
        font-size: 18px;
    }
    
    .box-ogsi-review-distribution .bar-holder {
        padding: 20px 50px;
    }
    
    .bar-value {
        font-size: 13px;
        color: white;
        font-weight: bold;
        display: inline-block;
        padding-top: 4px;
    }
    
    .bar-negative {
        height: 22px;
        background-image: url(http://staging.pickgrapevine.com/images/box/ogsi/bar-negative-bg.jpg);
        border: 1px solid #BC2B2C;
        border-radius: 8px;
        text-align: center;
    }
    
    .bar-neutral {
        height: 22px;
        margin-top: -1px;
        margin-left: -1px;
        float: left;
        background-image: url(http://staging.pickgrapevine.com/images/box/ogsi/bar-neutral-bg.jpg);
        border: 1px solid #D1BC30;
        border-radius: 8px;
        overflow: visible;
    }

    .bar-neutral .bar-value {
        color: black;
    }

    .bar-positive {
        overflow: visible;
        height: 22px;
        margin-top: -1px;
        margin-left: -1px;
        float: left;
        background-image: url(http://staging.pickgrapevine.com/images/box/ogsi/bar-positive-bg.jpg);
        border: 1px solid #18693C;
        border-radius: 8px;
    }

    .bar-positive .bar-value {
        color: white;
    }
    
    .headline-arrow {
        background: url(http://staging.pickgrapevine.com/images/ogsi_headline.png) top left;
        height:54px;
        width:127px;
    }
    
    .current {
        background-position: left bottom;
        background-repeat: no-repeat;
        font-family: Verdana,Arial,Tahoma,sans-serif;
        font-size: 30px;
        font-weight: normal;
        padding-bottom: 6px;
        padding-left: -2px;
        text-align: left;
        letter-spacing: -2.1px;
    }

    </style>
  </head>
  <body>
      
    <div id="container">
<a href="http://grapevinebeta.com">
      <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEASABIAAD//gATQ3JlYXRlZCB3aXRoIEdJTVD/2wBDAAIBAQEBAQIBAQEC
AgICAgQDAgICAgUEBAMEBgUGBgYFBgYGBwkIBgcJBwYGCAsICQoKCgoKBggLDAsKDAkKCgr/2wBD
AQICAgICAgUDAwUKBwYHCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoK
CgoKCgoKCgr/wAARCABGATQDASIAAhEBAxEB/8QAHgAAAQQDAQEBAAAAAAAAAAAAAAYHCAkBBAUC
Awr/xABWEAABAgUDAwEFAwUHDg0FAAABAgMEBQYHEQAIIQkSMRMUIkFRYQoycRUWI4HwFxgkJTNC
kTRSU1ZicnWClKGx0+HxGRomKUNjc3R2s8HR0pKXoqPU/8QAGgEAAgMBAQAAAAAAAAAAAAAAAwQA
AgUBBv/EADwRAAEDAgQCCAQCCAcAAAAAAAECAxEABBIhMUEFURMUImFxscHwgZGh0TJSBhVCU2Jy
kvEjMzQ1ssLh/9oADAMBAAIRAxEAPwC2uhN4t47qUdLbkW62gzSLp+eQaI2SRkdW8qhXYmEc5adU
yp0qaKk4V2HkZwecgdYbh9yp8bMYn/7jSj/WaTGxcoa2TWlUSAkW7lHPgAeyt6xeDebtssvURoq5
d7ackE39nREGXzWYpaeDS89q+08gHB1rKaSXlNttgwT+bb41pdWbmAPOlE/uY3EQv9UbOn0fPNx5
R/rNaURu7vZDH9PtLWj6G48o/wBZpmZ/1EdoUR3+juVpBZPgibIOkXPN+m1aI7ixuFpZRPymiTjT
KLFatWfor710WqOXnUjnt7F1GDl/a32H45uRKf8A565086hdY0zKYqeTXbM57PBQzkREJYuHKVuF
CElauxJcHcrAOBkZ1FKeb29tT/d6V+KbX+EyTpvrn7vbBTGjJ3CQN4ZE+47KIlDbbUelRWpTSgAB
8SSQNNI4WhREt/8AL71YWjZ286t0oKt5JcqhZLcSmS6ZdPpTDTGBLyOxwsvtJdR3J/mq7VDI+B11
jyOB403m0iGiYHalbGAjIV1h1i3slbeZeSUqQtMCyFBSSAQQQQQcfhpwyrjAGvOuAJcIGxNZahCo
o7jjCR+OskHGAnHHva1ZvNpdIpTEzucRzcLBwUO4/FxLy+1DTSElSlqPwSEgknxqrebdV7qU71Lm
z2S9M7bxDO0hJItUMifzOXNuOvDJKXXHYlxuHZK0juDOFLAVyT8GLWyfvCSiABqSYA+PfRG2lO6a
DnVqWBgcY/b6axgqwEpOdVeCuPtLzeVC2tOqwM9gbkeVD5fy2edJ27HW63x7erXOWzvtYeSUxeGW
1BBlbc3lb3sU1kzrb/e+02h4AuJdbbSVocU2oLOACk6bHBrlZhtaFnkFT8fCiC1cOhB8DVsucnCR
yNAKSBjyec6iF1Zt+929jm2ukLwWkkUjiplPqqhoCNancO48yhhUI++sJDbiCFEtAAkkAZ4+TAzH
f31hd5M0iq+2A7cISV25biVsyWdT2FhQ/MwhXap7vjHUJUCoHAaQQnlJUSCdBY4XcvtB2QlOeZMD
L3lVUW61JxSAO81Z3nuGO3n6aOMYxyPPOqmKq6l/Wa2RzCXVpvX23yuPpB6PQxFxSYBhockntRFQ
Tq22nCArtDiTnB484sPrreFa2jdncTvThjEx1Lt0g3PoJlBCXolDraVMs85CXFLWlB8gKJz4zqtx
w25t8JyUFGAUmRPLxri2FojeeVOwe0cYPng6zwBjtOfnjVTVveoB1z96MtcuftX2+yCWUi/FLal0
SmChg2oJJSQHo99PrkEFKloSE9wIwCNd9+5/2laQj2+Is7T0wQgkqhkQ8lX4+OERCVK/AHn5aZPB
nkHCt1sHkViav1VQyKhPjVoufIPvHwMaPBwR+v8AbzqCvTc6r9ydw165ttA3eWkbou5ssh3HYduH
h3oduM9IBbrKmHipTLobIcBCihaAojtwO7rdTrqYVrsJv/aSmm5ZKXaOqVUVEVm9FQTr0YmFadZS
RDFDiQlfateMhQKu34A5WPDbsXQt47REjvETkfKqdA50mCM6mpwASRn8P2xoI7eCM/LGqvTvD68e
55Aultp2wyqlaMjx60hbmjEGIiIhjyhxSo55KnO5JB70toQc+6COdas4vp9pBtnAuVfUlipHO4KE
QXIiCh5ZLYlS0jk4bhIgPK/BGTx40ccId0LrYPIqE+Hs1fqqt1D51aYDx4P0OgKA4x51GHpi9R+n
OoPbKZx0xplNPVrS8Q3D1TT6HSpCe/u9OIZ7ve9NfYsFKveQpCgcjtUpo+oT1Y7zWv3FQ+yfYxaJ
itLiKabVNYiIhXIlEG4tv1Qy2y2pHctLRDi3FqCEBWCCQrtXRw67Xcm3iFDMzoBznlQww4XCiMxU
+uEjCv6NZHBwsefGTqrpq4n2luYITGJtVTsIlw5SwpqSAoGfkqIJ/pOdcic9T7q+7JZpAVBvr2sQ
EwpB6LQzGTKBgW2ljuVj3IqEdch0OEZKUOJHcRjjk6ZHB315NuIUeQUJ+FEFso5BQJ8atcTkK94f
qzrHwBI4+GdRF35b57uW92LSHe/sshpDPZK+9BR00TPpe67iVxALfcEtuoKFoeU2heSe3KvHacP3
tav7TG6Lb7Sd/aTCUwlSyZqJXDBfd7K/919gn4lt1LjZ/vPljSC7V5tgOqGUkd4I2PKgltaUYj4U
vwcAFQyNZyUgKH6uMj/31jwO5QGOfJ41Cqheofey/HVUmmz+yEikDtuqGhHjW88i4R12KW80jtcS
04lxKGyIpxtkApJPpuHkca4zbO3AWU6JBJ8PelRCFKkjbOlPum2O3yvX1ArQbpaJuXL5fStBttJn
sliY2JQ++URDjqlNoQkoX3oWlB7inhHOR4ldjA4TxnwONQ83b7+rxWL6jtmNo9HSOQvU1XjLDk9i
Y6FcXFj1op5jDSkuBKO0NA8pVkk6VPVj3gXR2RbT/wB2mz8sk8TN11LBy5CZ1CuPMIbdS6pau1C0
Huw3gZPgnzppbF2+WGzHaEJ8JOvxoikOKwJO+lSaHk4BI+WDoJGe4A4Gquql6qXUu3ZVC5LenFtm
YmFOS1pliNqyLlPqNxUb6SS8G3Il1uHaQlfcEoV3r7QlRI7u0aU4vB9pUpSXCoJhZqWRrLKe92Gg
5bJ4lwgfD02Xy4o/RAJ+WjDg9xotxCTyKgD8qt1Ve5APjVqZOckY+usHk8Dj5ahD0qOq9UW9Cpp7
t+3AW/Ype5NOQyoh1iFacZaj2m1ht4ei6Sth5pakhTZJyFZGO0jSr6pfU0hthNNSOlaDotuqLg1e
tSafkjveWmWkqCC+6lv33MrUEIbSQVq7gFDtOVjw+7F2LbD2/pGszyjeqFhwO9HGdSz8juSk4+Oj
KCcjGB5wdVbQN5ftJtcQyahlFjpHJ4d9AU1CPy+VsKAPPLcTEF1BHjCsH5jWjVe8v7QDtllrtxL3
bb5PPqdgAXZmuHlUNEBpoDKlKMufK2wAD76klI8nwdMjg7qjCXWyeWIT4VfqqiYCh86tWJB5AHj4
qxo0xuyLftaTetYOAvVIIhqRxCopyCnUjjo1vvgI1sJUtsKOPUQUrQtK8DKVpyAcgGs1xpxlwoWm
CMjQFIcSqCKbHaJVvsmzC1UMlePTt7KkkfhDIGtra/S1E3G3i3gjKwo6VTYsUzSiWVTOXNPlvKZj
nt70ntzx4+Q01O2GqvZ9qNt2PV/k6Hlo5+kOjTndPqPMy3R3kie7P8QUsD/9Mx1tXCC2h5Q99oVp
XGTSve4qSZsbZPJULO0t5/tehv8A4aFWOsmDk2gpbH/h+G/1elTyc/LPOvlMIxuAgno9xtxaGWlL
UhlsqUoJGSAkcknwAPOsTpHOZrMk1HXcjeXavt0qmCoBzbdAVPP4qXmYPyuRSKVt+wwfqFpD77sW
tltAW4FIQnuK1lCyE4QTpt/3923SCcREI2GRja0KCkOJXSqVJI+IIj+D9RqEd097NvboV7P7n1fX
EPDzmppkYuMgXEL7pdDoT6cHAHggFhgJC8ces6+R97SIi9wlrZnEohIKtoRbr7gQ2gBY7lEgAcj5
69WzwgBsBYJO+voa1W7ROAYvWrMI/q80BKYV2YzPbxWTUNDtKdiXET2QOKS2kFSlBCJiVLIAJ7QC
Tjj4DUrKSqiTVvSksrSnX1Oy+cS5iOgHVIKStl1tLiFEHkEpUOPhqhGvZ6F01NEFWCqXvj/9ahq8
XbFj97bb3HxoeU5/yNrWZxawZtG0KbGp986Xu2EMgFO9IjqVzyNpzYFd+bS55xt5NAzFpLjSsKT6
jJbJB/BZ00HQIlUtlvTVpeKgIJtl2Onk3ejFoTgvOCMcaCl48qCG0Jz8kJ0/29u2k3vHtBuXbGnI
YvzGdUTMYaXMpSVFyIMOstJAHzWEj9Y1CzoG70bDyraYNt1wrkyanKopWeRqmpfPZi3CKjIV90vB
xsulIWoOOOIUke8ntBIGRobKFO8GcCBJCwT4QY+tDQCq1OHnVkhAx2jOPqdVh/aYaPkT1qbV16YB
v8pwtUxUvREhA7yw6wHCgnyQFMpI+WT89WIxF+LHwjanom8lKtoT95blQwyUj9ZX/s1U59oL3tWV
vpGUPYKytay+pvzdmj0zqGayiIS/CsPKSGmWEuoylawkuqV2kgZSPOcW4Gy8eJoUkGBMn4Gu2iV9
YBinh+0YY/eLWz7c4/PmE5+X8WRerAbCUlIqGsfR9G0xAIhZfK6YgIaDh2khIS2iHQkDj6D9Z51X
79ovUDsWtnj+3mE4z5/iuL1YlbRR/c4p8Ac/kSE/8lGqXX+1MfzL9Kq4T1dPifSmh6nVmqov7sUu
HaqhqUcnc8mMqaXJ5a0UBx2IaiWXkhHcQAf0fzH+fTdWytLbW2XR6ktpOoHAuSGnpVRzbdawkTHL
Q7DBMX6jTYWwSoud/ohKEEkqITgnjUvs/jn5A6gx9ocejWunc+3CLcShytZYmKCCcKb/AEygFfTu
CD+oaHYrW8pu0mAVgyNQdMvSuMqKylvaaau2fXo6d+2S3UpsbYyytx36Yp1hTErUWYb7hWpxSsvR
RWrK1qOVc8+BpQQf2l3aFERDbMfZK4zDSjhx4Q0CvsHzwInnUkunzt021U5s3ttHUNail3kzKi5b
GRs0EoYddjYh2GQt5xx0pKlLLhVkE+74GAANPDG2SsxM4dUHMbQUxEtqPvNPSCHWhXwwQUEf79He
f4SHVBTKiZOZVme85a1dS7bEZSfnVWMXuLs5uc67Fj78WCn/ALZKp7SzQjXC2Wn2ohMPM2nGH0Hl
DqUJQkjkYCSCQUnSt67lJSevd7G2ShqiYD0BOJ0YKOaI4cZdmEEhYx9UqI0mK+tLZOzP2h63FMWM
kUrlMDEwzUbOJTJ0pQxCR7kFG96Uto91rubS04UAAZczj3tKLr2VrKrbby9tdw5/kQMhmq5jGlPk
MszCCcWRgH+ak6128H6wtuimOjMTroqKYTHTIw/l+9WmMMMQrKIaHZS220gIbbbGEoSBgAAcAceB
r0cj3j5Hg61ZNOpRUcohqhkExZjoGNh0PwcbCuBbT7SwFJWlQ4KSCCCOCDrZWtDaVKdWEpAJKlEA
AY8nOvH6Vm+NVidPOChqG66m4mh6caTDy2MlsfFOwzYwj1FRkG6SB44U+5jjgK1H61+/i2Gx7qyb
gLzXmoSc1E5MajnUnli5N6KnobEyBPDy0jHpsJTkHIxjGCcP30yp5Kry9abcNeihoxEbIGpfGQzE
ex7zT/dGQzaFpV4wv2ZxSfmB+vXH2BRFtqH61G4W0d6JVKVR9UzeZvU4mcQraw64qO9qS036gOFr
Yd9QAfeDf4DXsCUJce6ROKGkSNDtP/taZKQVYhPZE/Sl0PtMO048/uC3E8YH6OA/zfwjTe7sOvzt
S3D7aq4sexYOtlP1PTcVAwapimCSw1ELQfSdUUvKI7HOxfCScp451aB+5DacebYU7+AkjHGf8TSL
3DzPbztqsjU19a9tdITK6ZlTsY+wzKIVLkQpIw2w2VJCe9xZShOT95Q1kM3PCw6koYVikR299tqW
S5bhQhGfjUZ+irTEovv0lmbQ3JhVxslmETPZK+055VCvOrKgk84wXlYPwUPppv8Aof3Fqfbfe+6f
TCu5Hn8oUxOoiZ0st0keu2lSUPhA/rXEGHiEJHkLcV8dTI2FboaM3g7cpbeu31tYilJNFTCKhoKU
PhodvouFClpDXu9pX3fXIOoXdZ2iqk2kbrbVdUW10vcJl01ZlNZtw3HrhKVdgWf+thi/DlR8djWO
dHaWbq7ftnBhLhJA5LGYz79DVgS44tsiMX0NTV397oJds92nVhfSJcb9vl8uVDSBhZz68ye/Rw6M
fzgFqClD+sQo6jx0FNsEytJtWidwNeNOOVVdePM1iIqKGXvYElYh+4nk+opbr5P84PI+Q0yfUoul
B9TXeXZjYdZKojG0m83C1JVMxgVZSGohgPd5wcBTUCVKTn+fFBJwRq0mQyKTUrI4Gmqel7UJLpdC
tQsDCsJwhlltIQhCR8AEgAD6aWeBsuGpaOSnO0f5RkB8TJqih0TATurM+G1Vs9SA/wDPg7Y/OBBy
8D6fxlF6cT7ROAenshIHH5+S3g/9nEabrqP89cHbJkEfwSX8H/CUXpxftExP/B7Ix4/PyW/+XEad
ajrNj4f9jRk5OM+96knsIoenbdbKbWUpTECiHhGqFlj5ShIHe69DIedcOPKluOLWT8So6dvA8gcH
4/HTd7QyP3qFsSPBt9Js/wCQs6cTJPIHGdYFwSp9ZPM+dIrJxmqw2ZTBUt9pZKpGyiHTOaXU/Goa
T2ha1SQ9xOPJJbSon56bfqu39pawHWnt9eS50gjZ5IqLpqWRn5Lgi36pIXFqQWw4QnKXlJc5I5T5
GnSnmP8AjLErA5/5HcAf4Fd0neoBM6RtJ14bQ3KvFDQSaUmlPwTDkVM2kKhU95jYXvX3gpAQ4tCi
TwkYUca9SyR1puRP+Bpue7xrRT/mCfy0tE/aYdph8WHuLgjkdkD/AE/1Try/9pb2kvsqYfsHcNba
0lKkLal5CgfIOYn4/wCz46n81ae0cQ0l5m2VOuIWkKQtMnYIIPgg9vI/bnXmJtXZ2Dh3IuKtvTbL
TTZcddck8OEoSkZKiSngAAnn5axuscI/cH+s/algu2n8B+dfmsld9qqkU5n79rHImSySZ1DFx0FL
GRkQ6HFDsR7vHuoCE/4ujVpUR169qMrnc0k9DbM51MZfBTN6HZmUuhoFLUWEK7Q6ABwFJCSM84Iz
o16sXd6R/pD/AFD7VoB17939aT236p/Ztt1CQwd+5SMAnj6MJH/pnTkbFdyliLLbhbqvXrvFTlKG
aySnDLPzhm7UJ7WGxHBZb9RQ7wkqSDjwSNR3szUCmbE0fD+pymmIP3fPHpJ1tRtxp9LWfZ5fO4hl
vuPuNukAE+f2+eknrZLwWg6H7g+lXca6RBTzqzGl98uzStaghKTpLdPb+YTKYRCWIGAhashFuxDq
jhKEJDmVKJ4AGSSQB506h8dwyB9Dg/79Ux0/M6svHdmh7Ov1FFvMVLXEsho1ovkj2VqITFRCvp2s
sOHPwxqWW9bqpQEDBx1vtsVRNIZClw0wuChtDyCsHC2ZU2rKIlxJyFRSwYdojA9ZY7Ri3HCFh1Lb
Oc6zsOem+fyrPdtClYSjOpN3R3EbPbRVIqm7vXht/T83Wn1nICeTiDYie1XIWpDigrBzwSOeeTqL
HVL3SbM7k7JKooy0N7qAnVQRkzknsEskU5hHop7sm0I4v00NkqOEJWo4HAST4zqAE5vBVEPFxL0k
ncZA+1PqeinG45xyIi3lfeeiH1EuRLqjyXFkk+AEpASExPL0XEeZchH68m6m3EqQ42qYOYWkjBB5
5B1sWvAg04hzESQQflny9aabscCgqdK5laT8OSaPSHPvQj3Pz9w6v22yZ/e2W9I/tHlOcf8Ac2tf
nTqeed0uim/UHLDgxn+5Ov0WbZeNttvkg+KIlIP+Rtar+kycDLXifIVXiOSU0o65qyAoKiJxXMyg
4iIhpLK4iPiWIRAU642y0pxSUAkZUQkgcgZI1XZQewDpr9YSl4/d1bGnq0t/GTGexMNPIOWxcKyV
xqOxS3Fsdr7aCsOIXlBT3FRJGSc2SRsFCTCDdgY2GQ8w80pD7TiQpK0EYKSPiDnVXFW9Hrf7tRuv
O6x6Z25diUU1PItT5kEfNVQzkOnJKWXELbcYiUoClJS4rtV28EZyTi8MW2kLAd6NeUHYjcH6RSdu
QAYVhO3Klm39mk2eBxJXey5K0g5WgxsAM/MZ9k1HzrEbKNsGxnb/AG3szYSURC55VFaux8wj5pGC
ImMc0zDhpPcoBPa2lcQkBKEpTlR4JydOs/t9+0iRqAy7ubkKQVD3m5hL0H+lEGDpT7WujXuAqDcX
Kt1PUev+3XM6kMQ1EymRQ0a9GNreaV3NB115CAlpCvf9FtASVeTjIVrN3brDgduboLCZOFJJJMZD
QUwlxSDiW5IGwp/+o50/Jt1ANulK2ehrktUpGyGdQ0yXFvysxSXCiFdYW0UBxHaf0pIOT93GOciS
lNyZNP07ASFuJ9b2CCahkulOCsIQE5x8PGts5SoYJyD8NZGTjGO748a80u4ecaS2o9lMkfHWkCtS
kxtQcDwcq03G7PbLQe8GwNQWAuK6+xAzthHpx0KB6sHENrS4y+nPBKVpSSnwoZSfOnHzjnJz8dY4
8nOdDQtbawtBgjMVxJKTIqqikuiD1HLLtLpmw3UUVJ5E24swsLCTaaQCPeJJUWGVLbSo+SQT511I
jpFdWqerELUnVCmIhikoc9GqpyokHyCkFAP6z/p1aH5OQTk/TR/dZ5B4OPP7f061Dxy/Jk4Z54R9
qY629O3yFV87ZehSNuW6agNy6NycVPYmmWXIipGI+ULL03mLiIhCnUOF4+k32vNpCVBaj6WSolfD
e9d+j5DcPertnoCrYJT8sns2VL5mwhfaVsPTCCbcAI+6e1RwfgdWkk8ZVn5gAZ1D7qDbALvbr91N
jb10BUkhg5VbmeJi6gbmj7yX1tJi4aI/QpQ2oLJDKk4UpOCRz5wSz4k67xBL1wvRKgDpsY07zVmn
1F4KWdAaj2z0St/9n41+m9sHUcmcopVt1ZlsviJtMoJTDZVkJLcMpTRVjypISCee0a+c26NXU/uR
BuUxdrqax8TJYlsoi4YTqbRaXUHylTS1toWPopWNWkFQx3dx8Z48nRnGe8njyDoX67viZ7M88Iny
qvW3u75CmI2BdPy0HT7tXE0BbuNippNJvEJiKiqSObSh+YOpBCB2pyG2kAqCUAnHcokkqJLSdSTo
40NvkraFvfQlxXKIryFh22YiZpgy/DzFDf8AJFxKVpU26gYSl1Jz2gAg9qcTSOTju+QGg/FJBJx9
3POP/TSiL+7buTcJX2zqefpQw84lzGDnVXEs6Q/Vvp6GEtkHU6jGoNsAMNmq51hKR4ASQoJH0B19
0dCPdpe2YwkLvC6h87qGSMvh16WwsTGx6iR/YzFuBtpWPC/TVj5HVoHk+CSfB7ToyFqGVH9XP6vG
nDxu+1BAPMJE+VX6273fIUl7JWat9t5tRIrLWukv5PkFPQKYWXQ3qFSsZJUtajypalFS1KPlSidc
TdltwpLdvt7qfb9W8R6EJUMvLTMwSwl1UFEJIWzEJScZKHEpVjI7sduRnTh/3x/DA0D5k/Djn4/7
9ZgdcDvSScUzPfrQMSgrFvUL+l10h5R09auqO5VT3Lh6uqCcwKJfL4qHlBhW4CE7w46kdziypTi0
t5ORgNj+uOpo8j4njnI+esHwPPwxn4/t+31yknjBOM+cavcXT148XXTKjXVuKcViUc6jDuW6d0Zf
/fTaneNC3TbljFu2mW4mQrlZdVGpaiHX0lDocT6eS6UnKVYwDznAUPUj2WTHfrtwNipXcJqmn0T6
FmTcyiJeYlH6FK0lBQFo8hwnOeCkafwEnjOAD5x8NGc+ckAHH+jV03lwFtqCs0fhy038+dW6VyQZ
00pP2koNNrbV01bFEzVGopyn4OWCLU32F/0GENd5Tk9uewHGTjPnShyPH838NYz8E+B8vGNGccDO
M8Z+J0uVFRk6mqEkmajFHdO+Njep3DdQdd00CGh6f9h/NYSv9Ip32RUL3+v6mO3Cu7HZ8APrrsdQ
/pzWp6htt4Klqvmz8jn8jdW7TlSwUOl1cJ3hIcbcbJAdaX2IynKSCkEEcgvhSddUjXTEe7R9QMTB
uVzaIlswMOvPoRbCux5lXjC0K4Ouqe3nKuCc/sP28aZN5dIdQvFCkAAbQBt/er9K4FAzmKqtpzot
dTu2EKmn7UdSeIl0oh09kNCMT+bwjaU+AAy2VoRx8Adb8f0XOpJc+EXTF8epvMoyRRA9ONg25rNI
1DzZ8hTTrrSFZ+Sifrq0MKKQcK4+nI4/Y6yR2/dPBPgac/Xd9M9meeFP2ovW3jy+QqPm0/ppbY9p
1oIa1MipRioHPaVxcyndQwjbsRGRK0oSpeAntbR2oQlKE8AJ5yoqUTUgwlPzSfqedGs5dy86srUs
knvoBccUZJqE8X0LttiHnGabvndmUS7vUYSUwFVNehCIJJDTYWwVBA8DJJ+p86hbumsXI9pW5+pr
J0lXlTT2VQkklcW1EVTMkxD6XXkvKX2lKEAJwE8Y+HnV1IJHAPBPOqaerHUMNLN/1wHop9LLUPK5
G2pxxeAAIILzk+B7/wDTnW/wa7u7q6KHFEiPUU/ZuuuOwozlTNzaLkEVMWJ7OHI192XF32SXsRJZ
h3/UbLbntCkqC1t9ilJLQKQsLIUrtylSaqivJpO6hhZJBQUdOZ5MXEw0qkkohC7ExChwhphlsZCR
wlKUgADAA404u1rZjua3zxyZhayUCmaHDpTHXGqOGUiFIB94QjSsKil+Rke4COVJ1aTs42O7PNjM
sU5QL0LNaqiWeyb1pO4hD8xiyR7wSrww2f7G2APHd3kZ1r3nE7Ww7P4l8ht4nbzpp66bZ0zNQ22q
9C+6d3ZWK53l11MaLhIhkLl1G0pFNe3JBGQuLiFJWhBHH6JAV9VJI7dPEv7PDs/XjuvBdJQI57p/
Df8A82pvpuFRvhFQQx+veNfQVvSjpy1O2D+C9eZc41xJxeLHh7hkKzVXVwozNQbb+zsbLfXQ5G3N
uZEtBYLjDk/hgHE/FJxDZGfHGDqddM03JqNpqXUhTsN6EvlcC1BwLAUT6bLSAhCcnk4SkDJ541hu
pJC9w1M2lf42tlqZwDgHoxiDnzzpO4vLq6A6ZZVGk0Jbjjn4jNfY8cpJz/o0HjBB+Hj5a8h1pf3X
En8Dr0QB4OdLUOg5A4V5+OjhOO1XHx0EDAwdGe0e6fPnXIqVnAx7p8fADQOBkDkHWCfBzz9NBI4U
DzrtSg4/XnRx5zz8sayceQedYBwcg8/hqVKAEnkk5zyANR3qKtt2dzNxtxLTWiuPS9LymiZdKYmF
i5jTC4+IioiKhnHCwvD7YS1lvJWAVDuSAPOpE5ye4k5z48aQFC2cmNJ3vuHdl6etPM1qzKUQ0Ghl
SVwvscO40oqVnCu4ryOBjGOfOmLdxDWMkAmMpE54k88tJ1q6CBJPvMUwlG7kN27ttrXbnqyqakl0
/XtSSiWTGiIKn3ELhGI5wQ6IhuNU+pS3QspcKCgJwojPGTo7l95VxLW1TcOJh90dv5FE0klx2nqG
/NtyZPTJDcKl1LcZFJdQIV99zubS2ACgFBOSdOpD7Sp6xtptpYkVpCGLoOeSGYREyEGv04tMviUP
KSlOco7wjAJJAJ8HSWrXaPuTXBXStvbO51DQ9H3RmUwj416eU9EPzGXuxsOll9tBbeS06n3R2KWM
pBGQrGtZt7hy3ipWECSIiBhxCP2VZxO0nnNMJUyVSY9n7V0pjdLcxd/cA/au1Nf0/SEpYtrKKkfj
I6nDM4r2qLeikeilJfbT6fayMk8jtwB7xITcZu+udNNr9t7lz26dF0FGVDNoyBqefzCXuRgT7KuI
Z/gEF3hTynXWUkgqIaQtRPdgaeC2dgpnQd54u6UVUTEQxEW+k1Npg24dQUlyCdill3uJxhQiAAnG
R2nnTbQOzC7dv6LtnFWtuNTiqqttMZ46yZ9KXXJfHw8zedW4hQbWHGloSU9q0k8hQ8HGhIdsSoJM
ADDGX8Kpkwf2sOoI3iJqqS1MZbeR9YpOSTezc/8Ae91/UMgrGmK2nUgrmWU3S1UQspdhISMMwMEl
DsRDd6ihbK4pxK0hQCvSA9050qpfdncpZa/i7a3ruDT9XSP9zKbVOiOltMmWxXtEG7DIUypPruo7
O10kKGCe7B+7k8O61gJ/R23W7FY7iK4VEx9TVDLajemNvaZWtUmfhRBNsutwzrilPoaXDocWSrK2
0rOB40lbCTKP3J7tnZlMdwcBcyVt2imknm04pmmFS6Wyz2qKhQ2wO5bnfEOpS6tQ7zgNJ90DywG7
Vxpa0JGETPZ/hTEHCAM5/LM5DSr4UKSSBlnt3Df+1fOw+/euK2rC2L8ZuLomrX69mTUNUdAyamHI
aIp5D8K68FIiC6ouhlaENL70+93ZBHGpUbiqiuLR9i6rqy1LUK7UUokj8dK2IxkutRDjI9QtFIUC
StKSkc8FQP0011nbA7sqEhaEtxPLv0o1SFDKYbMVIJPENTOewjEOtliGiAtZaaSQULWUZ7lNjGMn
T8TyZSiSySMm9QxTTEvhINx6Pee/k22UIUpalf3ISCT+vSF85bG6SplIIGw3zMTCU7ZaExqZoTyk
dICke5qP9ebz51CzOZ1XbuDg4+mpDYZ+voxLjZUuIffyuXsd4UOxKkMxClDBJHb418KPudujoCvb
Sou5cen6lldz1PQkdL4ClTALk8V+TnY5ssuh9frIBaW2e8A4woEeNIjYrtxlde7e7tSqIqmLi6ar
uKjaYo6dLhVNrNNQ7LsNBraSvBKEl9/tJwFAA+Dpx6F24biprXVuZpfO4dJRUotgh1yUN03LYluI
mkSqCXBIdiS84pLYS24tRSgKypXkAAaadTYsKW0I7MjMZns5RlkQowdNpyFXUGkkpy9jL61y0bq7
rHY41uB/ir8vrq5MuV/AVCH9E1F+Tz7nfnv9D4933/ex/N1irrmbyKyurdaTWQqGm/RtxM5W3J6Z
jJCFvTwvQLES8w5FriEJY++oJWE5BPPgA86Y7K9xq7bv7dZVdyk2KBarETuXvuSKIVNVNGa/lL2N
xXqhoBLhIDqQVKASMDk6eq11nI+gLuXGuTFTxmJYrmbQEZDQjbJSqEEPAtQxSok4WSW+4EeAdDW5
ZNBakYVElRAicipEDMcsXhnnNcJaTJEHXzHpNKytJrFyGkJtPYIp9eClr8Qz3pynuQ2pQzyM8gf5
x89RttXe/d9AWfkG5u481pyoqVnNr4ypJxLpZJvYFSWKag24mGbQ4qIWt8OguIUO3CFJyMDA1JWq
5M7UdLTKnWYgNqjpe9DocUnISVoKe7Hx+940h6FsE3Idp0t2vVJPERTTFBIpuOmMK32hwCE9mW6h
KicZ5IB+GNJW7rLbJCwCSRqJOGDMctjl5UJCkhOY/tUdrBb6Kvq65NtZLHblqKrhdduqh6ipWRUw
5CPU64uCdfQtDvqr9VtDjYYV6gGe9J48BdUlutuvUVDW+pR1Mr/P6dXWi6TqptuCV6LLUudiXI95
tsrynuhYdCkZUQkxCDzwNdy0Nk92lLRlEUrXF2aSbpeimUtPGmpREMxtQNtQqodluJ9VZbaT7yXF
JRnKmxjA1t0ftDfpfeLPNySqwbdkkdDPvyqm0w5HsM0iWYNiLjAvOD6jUE2nGM5Ufmc6DzvDitWQ
ECRG5BMD8KdZB00AkzRlqYKjp7nuFN9XO8WuKGsjU1WGa05IYld+o6joWfxUqUqElcGmNW37a+yl
YL7iWm1E+8kKWQTgZGuJIt710X6QusmgLv0vco0NS0BUksqWVU45CtuMeu77bAvMB1SS4lmHKkLQ
r/pUkg4xpx6g2aVfEW6msmp24Eth58i80RcGnYuMly3IVp5UWp5ENENhQUpBQtTalJIOVBQHGNK2
3tqb5TuPqqM3F1vI4yW1BI25TCUrSsG83AQreHQ88pT5KnHnQ6Ek4ACWwBnU6bhyGiQkHOfqnTsz
mJ3A1ymKmJnDoPcd3rSBe3o1PBbxI6hIoSwW1h6adS3M0sn11TZuXtzVX6Tu7fT9iWT24z3Jzn4a
Sk33a3uZp+1H7pF46XtgzWlCRNQTWqZrTZiIcxRcYVDy1AceQ20oMP8AcoqUSr0zgDnXpzpo1u9t
Uh7Iu3sYNUpq5yaxNWJl6v0sMuBVLVw4R3dwzA9rXnykaeW6lqr7Q9UyGodvtZ081K5dIHJRHUhV
0I+7Lnk9zamYlv0FAoebCCjkEFKyOPOulfDEKSG4ORBJEaAgHMEdqZzG2cVJYBEe48RvXc2z1lWd
bWkhKgrqsaVqOLXGRTbFQUhEpXAzKGQ8tLL6QFqDa1ICe9AUoJWFAHjRrV2vWVmthrZO0pUtRS+O
mkxn8xnMzdlcB7LCIfjIlb6mmGiSUtI7+1OTk9ufjo1i3S0C4X0eYnKJFAUG8R9+lOOeAU+fxGod
7sujNZDdjfyY7iqguZUctmsxRCqiJUluHiZcp5hpLKHVMrRlXuIQCkqwSDxyRo0auzcPWyippRBO
WXKuIWtsykxWpPum7uHhGENt7uYqZQcK2luGh4yEUwlpCRhKEoQVJQkAeEgDXIg9odypJE+zTS7i
31A8lDi8H/8AEaNGiBxZTnRUqJFLKm9tdRsBPrV4tw/HKlaXtP2EmMMUpcqhS8Y8lWjRqhUTUJNL
SS2hfhO3vnRV+s6UkBRLcAEhcctWjRoZJmhEma60NK2oUDCyr8dbHYEAAHRo1Wq1kjABz50EYAOf
OjRqVKCnAznQQAAT8dGjUqUEduCDo+udGjUqUHkefPnQQF5KgOOeANGjUqUHK8qJyfJB8HRjvyT8
E4z8dGjUipWfvKKz51gDuyo+f2/2f0aNGuQKlABVz3YIHBHw1hDaEpIbSEjHhIwNGjXYqV6+/wAk
ng51gJC/dPP46NGuQKlAAUnsAwAnAA+A0DKlcqPn/wB9GjXYFSjJxjJHnxoJBP69GjXIFSjhQ7Fc
p+Wj49uePnjRo12KlHOe0nPPH00E4OPr5GjRqVKAcDA/0eP1aFJCTjAPHx/bOjRqVKFcDtJznzrK
uDz5I5OjRrkCpWD3JOAo/XjRo0akCpX/2Q==" alt="Grapevine Manage Your Reviews" />
</a>
        <div style="float:right;">
            
            <h2>
                jacek.kromski@polcode.com
            </h2>
            Graph for <?php $d = Session::instance()->get('viewingRange');  ?>
            <?php echo $d['date']; ?> with  <?php echo $d['period']; ?> range.
            
            
        </div>
        <div class="clear"></div>
        
      <div id="main">
       <div id="page">
           
           <?php echo $html; ?>
       </div>
      </div>
    </div>
  </body>
</html>