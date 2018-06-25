<template>
    <div id="socialList">
                <div class="socialSticky">
                    <div class="socialShare" :class="{open: isSocialBlockOpen}" @click="isSocialBlockOpen=!isSocialBlockOpen">
                        <div class="sharebtn" role="button" tabindex="0" aria-haspopup="true">
                            <div class="icn share"></div>
                            Share
                        </div>
                        <ul class="sociallist" role="listbox">
                            <li>
                                <div onClick="window.open('https://twitter.com/intent/tweet?text=hereTitle&via=epconst&url=hereLink','sharer','toolbar=0,status=0,width=700,height=400');" href="javascript: void(0)" class="option twitter" role="option" tabindex="0">
                                    <span class="icn twitter-share"></span>
                                </div>
                            </li>
                            <li>
                                <div onClick="window.open('https://vkontakte.ru/share.php?url=hereLink','sharer','toolbar=0,status=0,width=700,height=400');" href="javascript: void(0)" class="option vkcom" role="option" tabindex="0">
                                    <span class="icn vk-share"></span>
                                </div>
                            </li>
                            <li>
                                <div onClick="window.open('https://www.facebook.com/sharer.php?u=hereLink','sharer','toolbar=0,status=0,width=700,height=400');" href="javascript: void(0)" class="option facebook" role="option" tabindex="0">
                                    <span class="icn fb-share"></span>
                                </div>
                            </li>
                            <li>
                                <div onClick="window.open('https://plus.google.com/share?url=hereLink','sharer','toolbar=0,status=0,width=700,height=400');" href="javascript: void(0)" class="option google" role="option" tabindex="0">
                                    <span class="icn google-share"></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
</template>

<script>
  export default {
    name: 'social',
    data() {
      return {
        isSocialBlockOpen: false,
      }
    },
  }  
</script>

