<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .sidebar {
            height: 90%;
            width: 200px;
            bottom: 0;
            left: -250px;
            background-color: #333;
            padding-top: 0px;
            transition: left 0.3s ease;
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            padding: 10px;
            color: #fff;
            cursor: pointer;
            transition: 0.3s;
        }

        .sidebar ul li:hover {
            background-color: #555;
        }

        .submenu {
            display: none;
        }

        .submenu.open {
            display: block;
        }

        .submenu ul {
            padding-left: 20px;
        }

        .secondSubmenu {
            display: none;
        }

        .secondSubmenu.open {
            display: block;
        }

        .search_member_container {
            width: 200px;
            display: flex;
            margin-left: 2px;
        }

        .search_container_start {
            display: flex;
            align-items: center;
        }

        .search_icon_container {
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 3px;
        }

        .search_icon {
            width: 30px;
            height: 30px;
            border-radius: 4px;
        }

        .search_input_container {
            display: flex;
            align-items: center;
            margin-right: 3px;
        }

        .search_input {
            width: 110px;
            height: 30px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 0 10px;
            outline: none;
        }

        .search_submit_btn_container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search_btn {
            width: 50px;
            height: 30px;
            background-color: #32cd80;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            user-select: none;
        }

        .search_input:focus {
            border-color: #66afe9;
            outline: 0;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
        }

        .sidebar-header {
            height: 20px;
        }
    </style>

</head>

<body>
    <div>
        <p>Search the Item you want: </p>

        <div class="search_member_container">
            <div class="search_container_start">

                <div class="search_icon_container">
                    <img class="search_icon" src="../icons/search.png" alt="Search Icon">
                </div>

                <div class="search_input_container">
                    <input class="search_input" id="searchInput" placeholder="search item" type="text">
                </div>

                <div class="search_submit_btn_container">
                    <div class="search_btn" id="searchBtn">Search</div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <br>
    </div>
    <div class="sidebar">
        <div class="sidebar-header"></div>
        <ul>
            <li class="mainButton">Browser Category</li>
            <div class="submenu">
                <ul>
                    <li class="expandable">Honda</li>
                    <div class="secondSubmenu">
                        <ul>
                            <li class="secondExpandable" data-info="cars_info_1">Sedan</li>
                            <li class="secondExpandable" data-info="cars_info_2">Suv</li>
                            <li class="secondExpandable" data-info="cars_info_3">Wagon</li>
                        </ul>
                    </div>
                    <li class="expandable">Nissan</li>
                    <div class="secondSubmenu">
                        <ul>
                            <li class="secondExpandable" data-info="cars_info_4">Sedan</li>
                            <li class="secondExpandable" data-info="cars_info_5">Suv</li>
                            <li class="secondExpandable" data-info="cars_info_6">Wagon</li>
                        </ul>
                    </div>
                    <li class="expandable">Toyota</li>
                    <div class="secondSubmenu">
                        <ul>
                            <li class="secondExpandable" data-info="cars_info_7">Sedan</li>
                            <li class="secondExpandable" data-info="cars_info_8">Suv</li>
                            <li class="secondExpandable" data-info="cars_info_9">Wagon</li>
                        </ul>
                    </div>
                </ul>
            </div>
        </ul>
    </div>

    <div id="carInfoContainer"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mainButton = document.querySelector('.mainButton');
            var sidebar = document.querySelector('.sidebar');
            var submenu = mainButton.nextElementSibling;

            mainButton.addEventListener('click', function() {
                submenu.classList.toggle('open');
                sidebar.classList.toggle('open');
            });

            var expandables = document.querySelectorAll('.expandable');
            expandables.forEach(function(expandable) {
                expandable.addEventListener('click', function() {
                    var submenu = this.nextElementSibling;
                    if (submenu.classList.contains('open')) {
                        submenu.classList.remove('open');
                    } else {
                        closeAllSubmenus(submenu);
                        submenu.classList.add('open');
                    }
                });
            });

            var secondExpandables = document.querySelectorAll('.secondExpandable');
            secondExpandables.forEach(function(secondExpandable) {
                secondExpandable.addEventListener('click', function() {
                    var submenu = this.nextElementSibling;
                    if (submenu.classList.contains('open')) {
                        submenu.classList.remove('open');
                    } else {
                        closeAllThirdSubmenus(submenu);
                        submenu.classList.add('open');
                    }
                });
            });

            function closeMainMenus(exceptThis) {
                var submenus = document.querySelectorAll('.submenu');
                submenus.forEach(function(submenu) {
                    if (submenu !== exceptThis) {
                        submenu.classList.remove('open');
                    }
                });
            }

            function closeAllSubmenus(exceptThis) {
                var submenus = document.querySelectorAll('.secondSubmenu');
                submenus.forEach(function(submenu) {
                    if (submenu !== exceptThis) {
                        submenu.classList.remove('open');
                    }
                });
            }

            var submenuItems = document.querySelectorAll('.secondSubmenu li');
            submenuItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    var info = this.getAttribute('data-info');
                    console.log("Clicked on submenu with text: " + info);
                    sidebar.classList.remove('open');
                    closeMainMenus();
                    closeAllSubmenus();

                    var params = new URLSearchParams();
                    params.append('info', info);
                    parent.document.getElementById("mainPanel").src = "component/main.php?" + params.toString();
                });
            });

            // 搜索功能的事件监听器
            var searchBtn = document.getElementById('searchBtn');
            searchBtn.addEventListener('click', function() {
                var searchInput = document.getElementById('searchInput').value;
                console.log("Search input value: " + searchInput);
                var params = new URLSearchParams();
                params.append('info', searchInput);
                parent.document.getElementById("mainPanel").src = "component/main.php?" + params.toString();
            });
        });
    </script>

</body>

</html>