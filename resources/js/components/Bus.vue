<template>
    <div>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <form @submit.prevent="saveBus()" class="bus-form">
                <h2>Buses</h2>
                <div class="form-group">
                    <input v-model="bus.depart_loc" type="text" class="form-control" placeholder="Departure location" required><br>
                    <input v-model="bus.arrival_loc" type="text" class="form-control" placeholder="Arrival location" required><br>
                    <input v-model="bus.depart_date" type="date" class="form-control" placeholder="Departure date" required><br>
                    <input v-model="bus.depart_time" type="time" class="form-control" placeholder="Departure time" required><br>
                    <input v-model="bus.arrival_time" type="time" class="form-control" placeholder="Departure location" required><br>
                    <button type="submit" class="btn btn-success">save</button>
                </div>
            </form>
        </div>

        <div class="col-md-6 col-sm-6 timetable-wrap">
            <h2>Current Timetable</h2>
            <ul class="pagination">
                <li class="page-item" v-bind:class="[{disabled: !pagination.prevPageURL}]">
                <a class="page-link" href="#" @click="fetchAllBuses(pagination.prevPageURL)">&laquo;</a>
                </li>
                <li class="page-item active" v-bind:class="[{disabled: !pagination.prevPageURL}]">
                <a class="page-link" href="#" @click="fetchAllBuses(pagination.prevPageURL)">Previous</a>
                </li>
                <li class="page-item disabled">
                <a class="page-link text-primary" href="#">{{pagination.currentPage}} of {{pagination.lastPage}}</a>
                </li>
                <li class="page-item" v-bind:class="[{disabled: !pagination.nextPageURL}]">
                <a class="page-link" href="#" @click="fetchAllBuses(pagination.nextPageURL)">Next</a>
                </li>
                <li class="page-item" v-bind:class="[{disabled: !pagination.nextPageURL}]">
                <a class="page-link" href="#" @click="fetchAllBuses(pagination.nextPageURL)">&raquo;</a>
                </li>
            </ul>
            <div class="timetable">
            <div>
            </div>
            <div v-for="bus in buses" v-bind:key="bus.id" class="card card-body mb-2">
                <h4>{{bus.depart_loc}} <span>-</span> {{bus.arrival_loc}}</h4>
                <h5 class="text-capitalize">Date: {{bus.depart_date}}</h5>
                <h6 class="text-secondary text-capitalize">Depart at: {{bus.depart_time}} Expected arrival at: {{bus.arrival_time}}</h6>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-danger mr-2" @click="deleteBus(bus.id)">Delete</button>
                    <button type="button" class="btn btn-outline-warning" @click="editBus(bus)">Edit</button>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            buses: [],
            bus : {
                id: '',
                depart_loc : '',
                arrival_loc : '',
                depart_date : '',
                depart_time : '',
                arrival_time : ''
            },
            bus_id : '',
            pagination: {},
            edit : false
        }
    },

    created(){
        this.fetchAllBuses();
        console.log(this.buses);
    },

    methods: {
        fetchAllBuses(paginateURL){
            let fetchAllBuses = this;
            paginateURL = paginateURL || 'api/buses';//:: paginateURL is equal to paginateURL if there is one, else 'api/buses'.
            fetch(paginateURL)
            .then(res => res.json())//:: gets data object.
            .then(res => {//:: gets the actual data.
                this.buses=res.data;
                console.log(this.buses);
                fetchAllBuses.createPagination(res.meta, res.links);
                
                this.buses.forEach(bus => {
                    bus.depart_date = this.dateFormatter(bus.depart_date);
                });
            }).catch((err)=>{
                console.log('Pagination Error: '+err);
            })
        },
        createPagination(meta, links){
            let currentPagination = {//:: info such as what page you're currently on, next, prev.
                currentPage: meta.current_page,
                lastPage: meta.last_page,

                nextPageURL: links.next,
                prevPageURL: links.prev,
            }

            this.pagination = currentPagination;
        },
        deleteBus(id){
            if(confirm('Are you sure that you want to permanetly delete the selected item?')){
                fetch(`api/buses/${id}`,{
                method: 'delete',
            }).then(res => res.json())
              .then(res => {
                  alert('Bus has been removed.');
                  this.fetchAllBuses();
              })
              .catch((err) => console.log('Delete Error: '+err))
            }
        },
        saveBus(){
            if(!this.edit){
                fetch('api/buses', {
                    method: 'POST',
                    body:JSON.stringify(this.bus),
                    headers: {
                        'content-type': 'application/json'
                    }
                }).then(res => res.json())
                  .then(res => {
                       this.depart_loc = '';
                       this.depart_date = '';
                       this.depart_time = '';
                       this.arrival_time = '';
                       alert('New bus time has been created!');
                       this.fetchAllBuses();
                  })
                  .catch(err => {
                      console.log('Edit error: '+ err);
                  })
            }else{
                fetch('api/buses', {
                    method: 'PUT',
                    body:JSON.stringify(this.bus),
                    headers: {
                        'content-type': 'application/json'
                    }
                }).then(res => res.json())
                  .then(res => {
                       this.depart_loc = '';
                       this.depart_date = '';
                       this.depart_time = '';
                       this.arrival_time = '';
                       alert('New bus time has been updated!');
                       this.fetchAllBuses();
                  })
                  .catch(err => {
                      console.log('Edit error: '+ err);
                  })
            }
        },
        editBus(bus){
            console.log("as");
            this.edit=true;
            this.bus.id=bus.id;
            this.bus.bus_id = bus.id;

            this.bus.depart_loc = bus.depart_loc;
            this.bus.arrival_loc = bus.arrival_loc;
            this.bus.depart_date = this.dateFormatter(bus.depart_date);
            this.bus.depart_time = bus.depart_time;
            this.bus.arrival_time = bus.arrival_time;
        },
        dateFormatter(date) {
            let res = date.split("-", 3);
            return res[2]+'-'+res[1]+'-'+res[0];
        }

    }

}
</script>

<style>
    .timetable{
        overflow-y: scroll;
        max-height: 600px;
        max-width: 600px;
    }
    .timetable-wrap{
        margin-left: 7rem;
    }
    .bus-form{
        max-width: 400px;
    }
    @media screen and (max-width: 807px) {
        .timetable-wrap{
            margin-left: 0;
        }
        .timetable{
            min-width: 350px;
        }
    }
</style>