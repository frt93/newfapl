<template>
</template>

<script type="text/babel">
    export default {
        name: 'selectPlugin',
        methods: {
            attachSelect() {
                let tags = document.getElementById('tags');
                let staff = document.getElementById('staff');
                let clubs = document.getElementById('clubs');
                let players = document.getElementById('players');
                let categories = document.getElementById('categories');
                let competitions = document.getElementById('competitions');

                $(tags).select2({placeholder: 'Выберите теги', tags: true});
                $(staff).select2({placeholder: 'Выберите персонал'});
                $(clubs).select2({placeholder: 'Выберите клубы'});
                $(players).select2({placeholder: 'Выберите игроков'});
                $(categories).select2({placeholder: 'Выберите категории'});
                $(competitions).select2({placeholder: 'Выберите турниры'});
            }
        },
        mounted() {
            this.attachSelect()
        }
    }
</script>