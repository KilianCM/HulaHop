<template>
    <div>
        <h1>HomePage</h1>
        <h2>Title2</h2>
        <h3>Title3</h3>
        <div class="list">
            <ul>
                <li>Test Less</li>
                <li>Test</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "HomePage"
    }
</script>

<style scoped lang="less">

    .list {
        ul li {
            font-style: italic;
        }
    }

</style>