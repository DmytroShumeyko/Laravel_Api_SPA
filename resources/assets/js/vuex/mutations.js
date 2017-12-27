const setData = (state, data) => {
    state.companies = data.companies;
    state.vendors = data.vendors;
    state.products = data.products;
    state.orders = data.orders;
    state.sales = data.sales;
    let user = {
        'id': data.id,
        'phone': data.phone,
        'chart': data.chart
    };
    state.user = user;
};

/**
 * Order mutation
 *
 * @param state
 * @param data
 */
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

/**
 * Sale mutation
 *
 * @param state
 * @param data
 */
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

/**
 * Payment mutation
 *
 * @param state
 * @param data
 */
const addPayment = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    state.companies[companyIndex].payments.unshift(data);
    $('#pwModal').modal('hide');
};
const updatePayment = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    let index = state.payments.findIndex((x) => x.id === data.id);
    state.companies[companyIndex].payments[index] = data;
    $('#pwModal').modal('hide');
};
const delPayment = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    let index = state.payments.findIndex((x) => x.id === data.id);
    state.companies[companyIndex].payments.splice(index, 1);
};

/**
 * Withdraw mutation
 *
 * @param state
 * @param data
 */
const addWithdraw = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    state.companies[companyIndex].withdraws.unshift(data);
    $('#pwModal').modal('hide');
};
const updateWithdraw = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    let index = state.withdraws.findIndex((x) => x.id === data.id);
    state.companies[companyIndex].withdraws[index] = data;
    $('#pwModal').modal('hide');
};
const delWithdraw = (state, data) => {
    let companyIndex = state.companies.findIndex((x) => x.id === data.company_id);
    let index = state.withdraws.findIndex((x) => x.id === data.id);
    state.companies[companyIndex].withdraws.splice(index, 1);
};

/**
 * Company mutation
 *
 * @param state
 * @param data
 */
const addCompany = (state, data) => {
    state.companies.unshift(data);
    $('#companyModal').modal('hide');
};
const updateCompany = (state, data) => {
    let index = state.companies.findIndex((x) => x.id === data.id);
    state.companies[index] = data;
    $('#companyModal').modal('hide');
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
    setData,
    ajax,
    addOrder,
    updateOrder,
    delOrder,
    addErrors,
    clearErrors,
    addSale,
    delSale,
    updateSale,
    addCompany,
    addPayment,
    addWithdraw,
    delPayment,
    delWithdraw,
    updateCompany,
    updatePayment,
    updateWithdraw
}