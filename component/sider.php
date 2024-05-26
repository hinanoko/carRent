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

        .recent-searches {
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            max-height: 200px;
            overflow-y: auto;
            z-index: 1;
            width: 200px;
        }

        .recent-searches-header {
            padding: 8px 12px;
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .recent-searches ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .recent-searches li {
            padding: 8px 12px;
            cursor: pointer;
        }

        .recent-searches li:hover {
            background-color: #f5f5f5;
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
        var recentSearches = []; // Initialize an empty array
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
            var searchInput = document.getElementById('searchInput');
            var searchBtn = document.getElementById('searchBtn');
            var recentSearchesContainer;

            searchBtn.addEventListener('click', function() {
                var searchInputValue = searchInput.value.trim();
                if (searchInputValue !== '') {
                    console.log("Search input value: " + searchInputValue);
                    updateRecentSearches(searchInputValue);

                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "../controller/search_car.php", true);
                    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                console.log(response); // 调试输出
                                displaySearchResults(response);
                            } else {
                                console.error("Error:", xhr.statusText);
                            }
                        }
                    };
                    xhr.send(JSON.stringify({
                        query: searchInputValue
                    }));
                }
            });

            searchInput.addEventListener('focus', function() {
                displayRecentSearches();
            });

            searchInput.addEventListener('input', function() {
                if (searchInput.value.trim() === '') {
                    displayRecentSearches();
                } else {
                    if (recentSearchesContainer) {
                        recentSearchesContainer.style.display = 'none';
                    }
                }
            });

            searchInput.addEventListener('blur', function() {
                setTimeout(function() { // Delay to allow click event on recent searches
                    if (recentSearchesContainer) {
                        recentSearchesContainer.style.display = 'none';
                    }
                }, 200);
            });

            function displayRecentSearches() {
                if (recentSearchesContainer) {
                    recentSearchesContainer.remove();
                }

                recentSearchesContainer = document.createElement('div');
                recentSearchesContainer.classList.add('recent-searches');

                var recentSearchesHeader = document.createElement('div');
                recentSearchesHeader.classList.add('recent-searches-header');
                recentSearchesHeader.textContent = 'Recent Searches';
                recentSearchesContainer.appendChild(recentSearchesHeader);

                if (recentSearches.length > 0) {
                    var recentSearchesList = document.createElement('ul');
                    recentSearches.forEach(function(keyword) {
                        var listItem = document.createElement('li');
                        listItem.textContent = keyword;
                        listItem.addEventListener('click', function() {
                            searchInput.value = keyword;
                            recentSearchesContainer.remove();
                        });
                        recentSearchesList.appendChild(listItem);
                    });
                    recentSearchesContainer.appendChild(recentSearchesList);
                } else {
                    var noRecentSearches = document.createElement('div');
                    noRecentSearches.textContent = 'No recent searches';
                    recentSearchesContainer.appendChild(noRecentSearches);
                }

                document.body.appendChild(recentSearchesContainer);
                positionRecentSearchesContainer();
            }

            function positionRecentSearchesContainer() {
                var searchInputRect = searchInput.getBoundingClientRect();
                recentSearchesContainer.style.left = searchInputRect.left + 'px';
                recentSearchesContainer.style.top = (searchInputRect.bottom + window.scrollY - 1) + 'px'; // Adjusted to be closer
            }

            function updateRecentSearches(searchInputValue) {
                if (!recentSearches.includes(searchInputValue)) {
                    recentSearches.push(searchInputValue);
                    if (recentSearches.length > 5) { // Limit the number of recent searches
                        recentSearches.shift();
                    }
                }
            }

            function displaySearchResults(results) {
                // 将搜索结果传递给mainPanel中的页面
                var params = new URLSearchParams();
                params.append('results', JSON.stringify(results));
                parent.document.getElementById("mainPanel").src = "component/searchMain.php?" + params.toString();
            }
        });
    </script>
</body>

</html>