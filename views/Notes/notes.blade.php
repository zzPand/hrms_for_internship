@extends('layouts.master')
@section('content')

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title">
                        <span>Main</span>
                    </li>
                    <li class="">
                        <a href="#">
                            <li><a href="{{ route('home') }}">Dashboard</a></li>
                        </a>
                    </li>
                    @if (Auth::user()->role_name=='Admin')
                        <li class="menu-title"> <span>Authentication</span> </li>
                    @endif
                    <li class="">
                        <a class="active" href="{{ route('form/training/list/page') }}"> Assign Project </a>
                    </li>
                    <li class="">
                        <a class="active" href="{{ route('training/list2/page') }}"> Daily Report </a>
                    </li>
                    <li class="">
                        <a class="active" href="{{ route('training/list3/page') }}"> Monthly Report </a>
                    </li>
                    <li class="">
                        <a class="active" href="{{ route('notes') }}"> Log Book </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Sidebar -->


    <div class="page-wrapper">

            <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Log Book</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Log Book</li>
                        </ul>
                    </div>
                </div>
            </div>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes App</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

    <div class="container">
        <h1><img src="images/notes.png">Notes</h1>
        <button class="btn"><img src="images/edit.png">Create Notes</button>
        <div class="notes-container">

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const notesContainer = document.querySelector(".notes-container");
            const createBtn = document.querySelector(".btn");
            let notes = document.querySelectorAll(".input-box");

            function showNotes() {
                notesContainer.innerHTML = localStorage.getItem("notes");
            }
            showNotes();

            function updateStorage() {
                localStorage.setItem("notes", notesContainer.innerHTML);
            }

            createBtn.addEventListener("click", () => {
                let inputBox = document.createElement("p");
                let img = document.createElement("img");
                inputBox.className = "input-box";
                inputBox.setAttribute("contenteditable", "true");
                img.src = "images/delete.png";
                notesContainer.appendChild(inputBox).appendChild(img);
            });

            notesContainer.addEventListener("click", function(e) {
                if (e.target.tagName === "IMG") {
                    e.target.parentElement.remove();
                    updateStorage();
                } else if (e.target.tagName === "P") {
                    notes = document.querySelectorAll(".input-box");
                    notes.forEach(nt => {
                        nt.onkeyup = function() {
                            updateStorage();
                        };
                    });
                }
            });

            document.addEventListener("keydown", (event) => {
                if (event.key === "Enter") {
                    document.execCommand("insertLineBreak");
                    event.preventDefault();
                }
            });
        });
    </script>

</body>
</html>
            </div></div>

<style>
*{
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    box-sizing: border-box;
}

.container{
    width: 100%;
    min-height: 100vh;
    background: linear-gradient(135deg, #cf9aff, #95c0ff);
    color: #fff;
    padding-top: 4%;
    padding-left: 10%;
}

.container h1{
    display: flex;
    align-items: center;
    font-size: 35px;
    font-weight: 600;
}

.container h1 img{
    width: 60px;
}

.container button img{
    width: 25px;
    margin-right: 8px;
}

.container button{
    display: flex;
    align-items: center;
    background: linear-gradient(#9418fd, #571094);
    color: #fff;
    font-size: 16px;
    outline: 0;
    border: 0;
    border-radius: 40px;
    padding: 15px 25px;
    cursor: pointer;
}

.input-box{
    position: relative;
    width: 100%;
    max-width: 500px;
    min-height: 150px;
    background: #fff;
    color: #333;
    padding: 20px;
    margin: 20px 0;
    outline: none;
    border-radius: 5px;
}

.input-box img{
    width: 25px;
    position: absolute;
    bottom: 15px;
    right: 15px;
    cursor: pointer;
}
</style>
@endsection
