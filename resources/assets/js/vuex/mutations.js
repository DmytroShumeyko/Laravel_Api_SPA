const setData = (state, data) => {
    state.companies = data.companies;
    state.vendors = data.vendors;
    state.products = data.products;
    state.payments = data.payments;
    state.withdraws = data.withdraws;
    state.orders = data.orders;
    state.sales = data.sales;
    let user = {
        'id': data.id,
        'phone': data.phone,
        'chart' : data.chart
    };
    state.user = user;
};
const addOrder = (state, data) => {
    state.orders.unshift(data);
    $('#orderModal').modal('hide');
};
const updateOrder = (state, data) => {
    let index = state.orders.findIndex((x) => x.id === data.id);
    state.orders[index] = data;
    $('#orderModal').modal('hide');
};
const delOrder = (state, data) => {
    let index = state.orders.findIndex((x) => x.id === data.id);
    state.orders.splice(index, 1);
};
const addSale = (state, data) => {
    state.sales.unshift(data);
    $('#saleModal').modal('hide');
};
const updateSale = (state, data) => {
    let index = state.sales.findIndex((x) => x.id === data.id);
    state.sales[index] = data;
    $('#saleModal').modal('hide');
};
const delSale = (state, data) => {
    let index = state.sales.findIndex((x) => x.id === data.id);
    state.sales.splice(index, 1);
};
const ajax = (state, data) => {
    state.ajax = data;
};
const addErrors = (state, {data}) => {
    state.errors = data;
};
const clearErrors = (state) => {
    state.errors = '';
};
export {
    setData, ajax, addOrder, updateOrder, delOrder, addErrors, clearErrors, addSale, delSale, updateSale
}