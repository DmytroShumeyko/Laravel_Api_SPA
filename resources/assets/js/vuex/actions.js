
const  loadData =({commit}) => {
    axios.get('/api/user_data')
        .then(({data}) => {
            commit('setData', data);
        });
};
const createOrder = ({commit}, data) => {
    commit('ajax',false);
    axios.post('/api/orders/', {'order' : data, 'company_id' : data.company_id})
        .then(({data}) => {
            commit('addOrder',data.data);
            commit('ajax', true);
            commit('clearErrors');
        })
        .catch(error => {
            commit('ajax', true);
            if (error.response.status === 422) {
                commit('addErrors', {data: error.response.data.errors});
            } else {
                commit('addErrors', {data: {error: ['Something went wrong. Please try again']}});
            }
        });
};
const editOrder = ({commit}, data) => {
    commit('ajax',false);
    axios.patch('/api/orders/' + data.id, {'order' : data, 'company_id' : data.company_id})
        .then(({data}) => {
            commit('updateOrder',data.data);
            commit('ajax', true);
            commit('clearErrors');
        })
        .catch(error => {
            console.log(error);
                commit('ajax', true);
                if (error.response.status === 422) {
                    commit('addErrors', {data: error.response.data.errors});
                } else {
                    commit('addErrors', {data: {error: ['Something went wrong. Please try again']}});
                }
        });
};
const deleteOrder =({commit}, data) => {
    commit('ajax',false);
    axios.delete('/api/orders/' + data.id)
        .then(({data}) => {
            commit('delOrder', data.data);
            commit('ajax', true);
        });
};

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



const createEmployee =({commit}, employee) =>{
    commit('ajax', false);
    axios.post('/employee', {name: employee.name, email: employee.email})
        .then(({data}) => {
            commit('addEmployee',data.data);
            commit('clearErrors');
            commit('ajax', true);
        })
        .catch(error => {
            //save errors
            commit('ajax',true);
            if (error.response.status === 422) {
                commit('addErrors', {data: error.response.data.errors});
            } else {
                commit('addErrors', {data: {error: ['Something went wrong. Please try again']}});
            }
        });
};

const delEmployee =({commit}, employee)=> {
    commit('ajax', false);
    axios.delete('/employee/' + employee.id)
        .then(({data}) => {
            commit('delEmployeeStore', data);
            commit('ajax', true);
        });
};

const changeGoal = ({commit,state }, goal)=> {
    commit('ajax',false);
    axios.put('/goal/'+state.goal.id, {goal_per_day: goal.goal_per_day, period: goal.period})
        .then(({data}) => {
            commit('updateGoalEdit',data);
            commit('clearErrors');
            commit('ajax',true);
        })
        .catch(error => {
            //save errors
            commit('ajax',true);
            if (error.response.status === 422) {
                commit('addErrors', {data: error.response.data.errors});
            } else {
                commit('addErrors', {data: {error: ['Something went wrong. Please try again']}});
            }
        });
};

const addGoal = ({commit}, goal) => {
    commit('ajax',false);
    axios.post('/goal', {goal_per_day: goal.goal_per_day, period: goal.period})
        .then(({data}) => {
            commit('flag', true);
            commit('updateGoalEdit',data);
            commit('calcProfitCircle');
            commit('clearErrors');
            commit('ajax', true);
        })
        .catch(error => {
            //save errors
            commit('ajax',true);
            if (error.response.status === 422) {
                commit('addErrors', {data: error.response.data.errors});
            } else {
                commit('addErrors', {data: {error: ['Something went wrong. Please try again']}});
            }
        });
};
export {addGoal,changeGoal,delEmployee,deleteOrder,createEmployee,createOrder,loadData, editOrder}