<?php include "../config/database.php";    ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery UI Dialog - Modal form</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="stylesheet" href="./style/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="../script/test.js"></script>
</head>

<body>
    <main>
        <header>
            <nav class="navs">
                <div class="logo">
                    <img class="logo-image" src="../images/contact.png" alt="logo">
                    <h1 class="title">Jokko</h1>
                </div>
                <ul class="nav-links">
                    <li>
                        <button id="btnOpenModal" class="create">
                            <svg style="width: 24px; height: 24px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Ajouter un contact
                        </button>

                    </li>
                    <li>
                        <button class="list" id="create-user">List of Contacts</button>
                    </li>
                </ul>
            </nav>

        </header>
        <div class="overlay" id="overlay"></div>


        <div id="myModal" class="modal">
            <div class="close-container">
                <button id="btnCloseModal" class="btn-close" class="btn-close" onclick="hideContactFormModal()">X</button>
            </div>

            <h1>Ajouter un contact</h1>
            <form id="formAjoutContact" action="ajax.php" method="post">

                <input class="input-modal" type="text" id="nom" name="nom" placeholder="Nom">
                <input class="input-modal" type="text" id="prenom" name="prenom" placeholder="Prénom">
                <input class="input-modal" type="text" id="numero" name="numero" placeholder="Numéro">
                <input class="input-modal" type="email" id="email" name="email" placeholder="Email">
                <button type="submit" class="btn">Ajouter Contact</button>
            </form>
        </div>
        <div id="editContactModal" class="modal">
            <div class="modal-content">
                <div class="close-container">
                    <button id="btnCloseModal" class="btn-close">X</button>
                </div>
                <h1>Modifier un contact</h1>
                <form id=" formEditContact" action="ajax.php" method="post">
                    <!-- Vos champs de formulaire ici -->
                    <input class="input-modal" type="text" id="editNom" name="nom" placeholder="Nom">
                    <input class="input-modal" type="text" id="editPrenom" name="prenom" placeholder="Prénom">
                    <input class="input-modal" type="text" id="editNumero" name="numero" placeholder="Numéro">
                    <input class="input-modal" type="email" id="editEmail" name="email" placeholder="Email">
                    <button id="btnEditContact" type="submit" class="btn">Modifier</button>
                </form>

            </div>
        </div>



        <div id="" class="container">
            <div class="filter">
                <div class="">
                    <form id="searchForm" class="" action="ajax.php" method="post">
                        <input id="name" class="search-input" name="nom" type="text" placeholder="Rechercher par nom">
                        <input id="prenom" class="search-input" type="text" name="surname" placeholder="Rechercher par Prénom">
                        <div>
                            <button type="submit" class="search">Rechercher</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>

        <div class="card-container">
            <div id="contactList"></div>
        </div>
    </main>


</body>

</html>