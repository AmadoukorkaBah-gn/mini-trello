# Mini Trello — Test Technique Full Stack Junior

Application de gestion de tâches collaboratives (type Trello), développée avec **Laravel 11**, **Blade** et **MySQL**.

---

## 🚀 Lancer le projet

### Prérequis
- PHP 8.2+
- Composer
- MySQL 8+
- Node.js (pour npm)

### Installation

```bash
git clone https://github.com/TON_USERNAME/projettest
cd projettest
composer install
cp .env.example .env
php artisan key:generate
```

Configurer `.env` :
```
DB_DATABASE=projettest
DB_USERNAME=root
DB_PASSWORD=
```

```bash
php artisan migrate
php artisan serve
```

---

## 🛠️ Choix techniques

| Technologie | Raison |
|---|---|
| Laravel 11 | Framework robuste, architecture MVC claire, ORM Eloquent |
| Blade | Templating natif Laravel, simple et efficace |
| MySQL | Base relationnelle adaptée aux données structurées |
| Tailwind CDN | UI rapide sans complexité de build |

---

## ✅ Clean Code / DRY / SOLID appliqués

### Clean Code
- Noms de méthodes expressifs : `getProjectsForUser`, `changeStatus`, `assignTask`
- Controllers fins — délèguent toute logique aux Services
- Form Requests dédiés pour la validation

### DRY
- Les Services centralisent la logique métier réutilisable
- Les Repositories abstraient toutes les requêtes DB
- La layout Blade `layouts/app.blade.php` évite la répétition HTML

### SOLID
- **SRP** : Controller → reçoit la requête, Service → logique métier, Repository → accès données
- **OCP** : Ajout d'une nouvelle source de données = nouvelle classe Repository sans toucher aux Services
- **DIP** : Les Services dépendent d'interfaces (`ProjectRepositoryInterface`), pas des implémentations concrètes — binding dans `AppServiceProvider`

---

## 🎯 Difficultés rencontrées
- Gestion du drag & drop en vanilla JS avec l'API Fetch pour la mise à jour asynchrone du statut
- Architecture SOLID en Laravel : le binding interface/implémentation via le Service Provider