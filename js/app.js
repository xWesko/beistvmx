
Vue.component('agenda', {
    props: ['arrayjuegos'],
    template: `
    <div class="col-md-4 kard">
        <table class="evento" width="100%">
            <thead class="titulo_evento">
                <tr>
                    <th> <img class="logo_equipo" src="" width="24" alt=""> </th>
                    <th v-text="data.games.game.away_team_city ">  </th>
                    <th> <img class="logo_equipo" src="" width="24" alt=""> </th>
                </tr>
            </thead>
        </table>
        
    </div>  
    `,
});



const layout = new Vue({
    el: '#verbeisbol',
    data() {
        return {
            arrayjuegos: [],
            liga: '',
            torneo: '',
            loading: true,
            errored: false
        }
    },
    methods : {
        juegos(){
            axios.get('http://gd.mlb.com/components/game/mlb/year_2019/month_09/day_21/master_scoreboard.json')
            .then(response => {
                this.arrayjuegos = response;
            })
            .catch(error => {
                console.log(error)
                this.errored = true
            }).finally(() => this.loading = false)
        }
    },
    mounted() {
        this.juegos();
    },
});