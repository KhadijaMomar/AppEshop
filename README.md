# E-Boutique Symfony

Ce projet est une **e-boutique** réalisée avec **Symfony 8**, permettant la gestion de produits, catégories et utilisateurs.  
Le panier est géré **en session**.

---

## Fonctionnalités

| Fonctionnalité | Statut | Commentaire |
|----------------|--------|------------|
| Login (connexion) | ✅ OK | Authentification fonctionnelle pour les utilisateurs existants |
| Inscription avec contrôle de majorité sur la date de naissance | ✅ OK | L’utilisateur doit avoir au moins 18 ans pour s’inscrire |
| Parcours par catégorie | ✅ OK | Affichage des catégories et des produits associés |
| Parcours des articles | ✅ OK | Détails des produits accessibles via `/product/{id}` |
| Mise au panier | ✅ OK | Ajout et suppression des produits dans la session |
| Ajustement des quantités au panier avec le prix total | ✅ OK | Possibilité d’incrémenter/décrémenter la quantité depuis le panier |
| Message de commande faite | ✅ OK | Flash message indiquant la réussite de la commande |
| Ajout d’un nouveau type d’article proposé (sans gestion de stock) | ✅ OK | Création d’un produit via formulaire |
| Ajout d’une nouvelle catégorie | ✅ OK | Création d’une catégorie via formulaire |
| Mise à jour du profil du client connecté | ✅ OK | Formulaire avec flash message de succès |
| Panier géré en **session** | ✅ OK | Les produits ajoutés sont stockés côté session PHP/Symfony |

---

## Améliorations apportées

- Design amélioré des formulaires (inscription, produit, catégorie, profil) avec **Bootstrap 5**  
- Messages **flash** pour toutes les actions (profil, création produit/catégorie, commande)  
- Validation stricte du **téléphone** (uniquement chiffres, longueur 10 à 15)  
- Ajustement dynamique des quantités directement dans le panier  
- Redirections cohérentes après actions (ex. après mise à jour du profil, ajout produit, etc.)  
- Messages clairs pour les erreurs de formulaire (email invalide, mot de passe trop court, etc.)  

---

## Routes principales

| Route | Description |
|-------|-------------|
| `/login` (`app_login`) | Connexion utilisateur |
| `/logout` (`app_logout`) | Déconnexion |
| `/register` (`app_register`) | Inscription avec contrôle de majorité |
| `/profile` (`app_profile`) | Mise à jour du profil utilisateur |
| `/products` (`product_list`) | Liste des produits |
| `/product/{id}` (`product_show`) | Détails d’un produit |
| `/product/create` (`product_new`) | Ajouter un produit |
| `/categories` (`app_categories`) | Liste des catégories |
| `/category/{id}` (`app_category_show`) | Détails d’une catégorie |
| `/category/create` (`app_category_new`) | Ajouter une catégorie |
| `/cart` (`cart_index`) | Affichage du panier |
| `/cart/add/{id}` (`cart_add`) | Ajouter un produit au panier |
| `/cart/remove/{id}` (`cart_remove`) | Supprimer un produit du panier |
| `/cart/decrease/{id}` (`cart_decrease`) | Décrémenter la quantité d’un produit |
| `/order` (`order_create`) | Valider la commande |
| `/home` (`home`) | Page d’accueil |
| `/user` (`app_user`) | Page liste utilisateurs (bonus, non utilisée) |

---

## Notes techniques

- **Panier en session :** Tous les produits ajoutés au panier sont stockés dans la session Symfony.  
- **Flash messages :** Utilisés pour indiquer le succès des actions (création, mise à jour, commande).  
- **Validation :** Téléphone uniquement numérique, mot de passe minimum 6 caractères, contrôle de majorité sur la date de naissance.  
- **Bootstrap 5** utilisé pour le style et les formulaires modernes.  

---

**Auteur :** Khadidiatou  
**Technologies :** Symfony 6, Doctrine ORM, Twig, Bootstrap 5