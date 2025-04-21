<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></p>

# Lexidoo 2025

## À propos de l'application

Lexidoo est une application web moderne développée avec les dernières technologies pour offrir une expérience utilisateur optimale et des fonctionnalités avancées.

## Stack Technique

- **Backend**: [Laravel 12](https://laravel.com/docs) - Le framework PHP élégant et expressif
- **Frontend**: [React 19](https://react.dev/) avec [TypeScript](https://www.typescriptlang.org/)
- **Communication**: [Inertia.js 2](https://inertiajs.com/) - Pour une expérience SPA sans API
- **Interface**: [shadcn/ui](https://ui.shadcn.com/) - Des composants React réutilisables et élégants

## Caractéristiques

- Architecture moderne basée sur les principes de POO
- Interface utilisateur réactive et intuitive
- Authentication sécurisée avec intégration SAML2
- Support multilingue avec Google Translate
- Génération de contenu audio via Google Text-to-Speech
- Importation et exportation de données Excel
- Intégration avec les réseaux sociaux

## Prérequis

- PHP 8.2 ou supérieur
- Composer 2.0+
- Node.js 18.0+ et npm
- Base de données MySQL ou PostgreSQL

## Installation

```bash
# Cloner le dépôt
git clone https://github.com/votre-utilisateur/lexidoo2025.git
cd lexidoo2025

# Installer les dépendances PHP
composer install

# Installer les dépendances JavaScript
npm install

# Configurer l'environnement
cp .env.example .env
php artisan key:generate

# Migrer la base de données
php artisan migrate

# Compiler les assets
npm run build
```

## Développement

```bash
# Lancer le serveur de développement Laravel
php artisan serve

# Compiler et hot-reload pour le développement
npm run dev
```

## Structure du Projet

Le projet suit l'architecture standard de Laravel avec quelques ajouts spécifiques:

- `app/Models` - Classes de modèles (POO)
- `app/Services` - Services métier pour la logique applicative
- `app/Http/Controllers` - Contrôleurs pour gérer les requêtes
- `resources/js` - Composants React et logique frontend
- `resources/views` - Templates pour les emails et vues statiques

## Déploiement

L'application peut être déployée sur tout serveur compatible PHP 8.2+. Suivez les bonnes pratiques de déploiement Laravel:

```bash
# Sur le serveur de production
composer install --optimize-autoloader --no-dev
npm install
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Documentation

Pour plus d'informations sur l'utilisation des différentes technologies:

- [Laravel Documentation](https://laravel.com/docs)
- [React Documentation](https://react.dev/learn)
- [Inertia.js Documentation](https://inertiajs.com/server-side-rendering)
- [shadcn/ui Documentation](https://ui.shadcn.com/docs)

## Licence

Cette application est un logiciel propriétaire. Tous droits réservés.
