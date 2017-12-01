<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-reponsive">
                        <table>
                            <tbody>
                            <th class="icon-wallet">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path></svg>
                            </th>
                            <th class="wallet-amount"><span class="icon-clp-icon" style="font-size: 16px;"></span>0.00  </th>
                            <th style="min-width: 500px;">
                                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#buy-package">Buy Package</a>
                                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#withdraw">Withdraw</a>
                                <a href="#" class="btn btn-success" disabled="true">Deposit</a>
                                <button class="btn btn-success" data-toggle="modal" data-target="#tranfer">Transfer</button>
                            </th>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    module.exports = {
        data : function () {
            return {
                greeting: 'hi'
            }
        }
    }
</script>


<style scoped={}>

</style>
