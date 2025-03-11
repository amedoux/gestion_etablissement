<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Styles généraux */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            color: #fff;
            background: url('https://wallpaperaccess.com/full/138728.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        .navbar a:hover {
            color: #4CAF50;
        }

        .container {
            margin-top: 100px;
            text-align: center;
            background: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
        }

        .container h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .container p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin: 10px;
            font-size: 1rem;
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            background: #4CAF50;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .btn:hover {
            background: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
        }

        .btn-secondary {
            background: #007BFF;
        }

        .btn-secondary:hover {
            background: #0056b3;
        }

        footer {
            margin-top: auto;
            text-align: center;
            width: 100%;
            color: #ddd;
            font-size: 0.9rem;
            padding: 10px;
            background: rgba(0, 0, 0, 0.8);
        }

        footer a {
            color: #4CAF50;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Barre de navigation -->
    <!-- <div class="navbar">
        <div><a href="#">Logo</a></div>
        <div>
            <a href="../views/classes/index.php">Classes</a>
            <a href="../views/cours/index.php">Cours</a>
            <a href="../views/etudiants/index.php">Étudiants</a>
            <a href="../views/profs/index.php">Professeurs</a>
            <a href="../views/emploi_du_temps/index.php">Emplois du Temps</a>
        </div>
    </div> -->

    <!-- Conteneur principal -->
    <div class="container">
        <h1>Bienvenue sur la Gestion des Classes</h1>
        <p>Explorez et gérez vos classes, cours, étudiants et professeurs facilement.</p>
        <a href="../views/classes/index.php" class="btn btn-secondary">Voir les Classes</a>
        <a href="../views/cours/index.php" class="btn btn-secondary">Voir les Cours</a>
        <a href="../views/etudiants/index.php" class="btn btn-secondary">Voir les Étudiants</a>
        <a href="../views/profs/index.php" class="btn btn-secondary">Voir les Professeurs</a>
        <a href="../views/emploi_du_temps/index.php" class="btn btn-secondary">Voir les Emplois du Temps</a>
    </div>

    <!-- Pied de page  et conss-->
    <footer>
        &copy; 2025 Gestion des Classes. Tous droits réservés. <a href="#">Conditions générales</a>
    </footer>
</body>
</html>
