// CommitChart.js
import { Bar } from 'vue-chartjs'

export default {
    name: 'barChart',
    extends: Bar,
    props: ['data', 'options'],
    mounted () {
        // this.renderChart(this.data, this.options);
    },
    watch: {
        'data.labels'() {
            this.renderChart(this.data, this.options);
        }
    }
}