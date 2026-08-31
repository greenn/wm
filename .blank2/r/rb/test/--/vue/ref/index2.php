<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Vue 3 CDN Example with :ref</title>
  <script src="https://unpkg.com/vue@3.2.19/dist/vue.global.js"></script>
</head>
<body>

  <div id="app">
    <button @click="callChildrenMethods">Call Validate on All Children</button>
    <div v-for="(item, index) in items" :key="index">
      <child-component :ref="function(el) { if(el) addChild(el, 'field-type') }"></child-component>
    </div>
  </div>

  <script>
    var ChildComponent = {
      template: '<div>I am a child</div>',
      mounted: function() {
        console.log('Child mounted');
      },
      methods: {
        validate: function() {
          console.log('Validating the child component');
        }
      }
    };

    var app = new Vue({
      el: '#app',
      components: {
        'child-component': ChildComponent
      },
      data: function() {
        return {
          items: [1, 2, 3],  // Dummy array to create multiple child components
          childComponents: []
        };
      },
      methods: {
        addChild: function(el, type) {
          console.log('Adding child', el, type);
          this.childComponents.push({ el: el, type: type });
        },
        callChildrenMethods: function() {
          this.childComponents.forEach(function(child) {
            child.el.validate();
          });
        }
      },
        mounted(){
          console.log('mounted', { childComponents: this.childComponents })
        }
    });
  </script>

</body>
</html>
