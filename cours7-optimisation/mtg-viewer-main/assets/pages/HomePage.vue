<template>
    <div>
        <h1>Home Page</h1>
    </div>
    <ul>
        <li><router-link :to="{ name: 'all-cards' }">Toutes les cartes</router-link></li>
        <li><router-link :to="{ name: 'search-cards' }">Rechercher une carte</router-link></li>
    </ul>
</template>
