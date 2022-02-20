<template>
  <div class="vuetable-info d-sm-flex align-items-center justify-content-between">
    <div :class="['vuetable-pagination-info', 'd-none d-md-block', $_css.infoClass]" v-html="paginationInfo">
    </div>
    <ul :class="$_css.wrapperClass">
      <li :class="['page-item', isOnFirstPage ? $_css.disabledClass : '']">
        <a @click="loadPage('prev')" :class="['page-link', $_css.linkClass]">
          Previous
        </a>
      </li>
      <template v-if="notEnoughPages">
        <li :class="['page-item', isCurrentPage(i+firstPage) ? $_css.activeClass : '']" v-for="(n, i) in totalPage" :key="i">
          <a @click="loadPage(i+firstPage)" :key="i"
            :class="[$_css.pageClass]"
            v-html="n">
          </a>
        </li>
      </template>
      <template v-else>
        <li :class="['page-item', isCurrentPage(i+firstPage) ? $_css.activeClass : '']" v-for="(n, i) in windowSize" :key="i">
          <a @click="loadPage(windowStart+i+firstPage-1)" :key="i"
            :class="[$_css.pageClass, isCurrentPage(windowStart+i+firstPage-1) ? $_css.activeClass : '']"
            v-html="windowStart+n-1">
          </a>
        </li>
      </template>
      <li :class="['page-item', isOnLastPage ? $_css.disabledClass : '']">
        <a @click="loadPage('next')"
          :class="[$_css.pageClass]">
          Next
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
import PaginationMixin from 'vuetable-2/src/components/VuetablePaginationMixin.vue'
import PaginationInfoMixin from 'vuetable-2/src/components/VuetablePaginationInfoMixin.vue'
export default {
  mixins: [PaginationMixin, PaginationInfoMixin],
}
</script>
<style lang="scss">
  .vuetable-pagination {
    background: #f9fafb !important;
  }
  .vuetable-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .pagination-filled .page-link{
    background-color: #e3e7ed;
    padding: 8px 10px;
    margin: 0;
    border: 0;
    min-width: 30px;
    border-radius: 1px;
    transition: all 0.2s ease-in-out;
   }
   .page-item:first-child,
    .page-item:last-child {
      .page-link {
        border-top-left-radius: 1px !important;
        border-bottom-left-radius: 1px !important;
        border-top-right-radius: 1px !important;
        border-bottom-right-radius: 1px !important;
      }
    } 
</style>
