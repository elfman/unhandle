<template>
  <div class="wrapper">
    <el-table>
      <el-table-column prop="vote_count"></el-table-column>
      <el-table-column prop="answer_count"></el-table-column>
      <el-table-column prop="title"></el-table-column>
    </el-table>
    <el-pagination></el-pagination>
  </div>
</template>

<script>
  import Vue from 'vue';
//  import { Pagination, Table } from 'element-ui';
  import ElPagination from "element-ui/packages/pagination/src/pagination";

//  Vue.use(Pagination);
//  Vue.use(Table);

  export default {
    components: { ElPagination },
    data() {
      return {};
    }
  }
</script>

<style lang="scss" scoped>

</style>