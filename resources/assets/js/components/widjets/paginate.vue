<template>
    <v-card>

        <v-card-text v-for="(page, index) in pages" :key="index">
            <div v-if="index + 1 == page_no">{{page}}</div>
        </v-card-text>
                  <v-pagination class="paginator"
                    v-if="length"
                    v-model="page_no"
                    :length="length"
                  ></v-pagination>
    </v-card>
</template>

<script>
export default {
    props: {
        text: {
            type: [String],
            default: '',
        },
        words: {
            type: [Number],
            default: 50,
        },
    },

    data: function(){
        return {
            page_no: 1,
            pages: null,
        }
    },

    computed: {
        length: function(){
        return this.pages ? this.pages.length : 0;
        },
    },

    created: function(){
        this.paginate(this.text, this.words);
    },

    methods: {
        paginate: function(text, words_per_page = 50){
        let text_array = text.split(" ");
        let pages = [];
        
        for(let i = 0, j = 0; i < text_array.length; i += words_per_page, j++){
            let start_word_position = j * words_per_page;
            let end_word_position = words_per_page * (j + 1);
            let page;
            page = end_word_position > text_array.length 
            ? text_array.slice(start_word_position, text_array.length) 
            : text_array.slice(start_word_position, end_word_position);
            page = page.join(" ");
            pages.push(page);
        }
        this.pages = pages;
        
        },
    },

}
</script>

<style scoped>
.paginator{
    width: 100%;
}
</style>