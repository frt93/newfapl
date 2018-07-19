<template>
    <div></div>
</template>

<script>
    export default {
        name: 'selectPlugin',
        methods: {
            attachSelect() {
                let tags = document.querySelectorAll("[name='tag_list[]']");
                let staff = document.querySelectorAll("[name='staff_list[]']");
                let clubs = document.querySelectorAll("[name='club_list[]']");
                let players = document.querySelectorAll("[name='player_list[]']");
                let categories = document.querySelectorAll("[name='category_list[]']");
                let competitions = document.querySelectorAll("[name='competition_list[]']");

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