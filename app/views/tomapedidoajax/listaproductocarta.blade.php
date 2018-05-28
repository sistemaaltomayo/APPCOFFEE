



{{--*/ $sw = 1 /*--}}
<ul class="cool-gallery">
  @foreach($listaCarta as $item)
        {{--*/ $activo = $item->Activo /*--}}
        <li id="li_{{$sw}}" name='{{$item->id}}' data='{{$item->idcarta}}'>
          <a href="#" class='@if($activo == 0) inactivo @endif'>
            <div class="image-wrapper">
              {{ HTML::image('img/blanco.png') }}
            </div>
            <input class="select-picture" id='{{$item->idcarta}}' type="checkbox" @if($activo == 1) checked @endif/>

            <p class='precio'>{{number_format($item->precio,2)}}</p>
            <p class='nombre'>{{$item->descripcion}}</p>
            <p class='item'>{{$sw}}</p>
            <input class="replace-caption" type="text" placeholder="Image label" value="{{$sw}}"/>
          </a>
        </li>

        {{--*/ $sw = $sw + 1 /*--}}
  @endforeach 
</ul>






{{ HTML::script('/js/coolGallery.js'); }}



<script type="text/javascript">


function coolGallery(target){
  
  this.init = function(target){
    this.setup(target);
    this.bind();
  };
  
  this.setup = function(target){
    this.elements = document.querySelector(".cool-gallery").children;
    this.isDragging = false;
  };
  
  this.bind = function(){
    var _this = this;
    
    for(i=0;i<_this.elements.length;i++){if (window.CP.shouldStopExecution(1)){break;}
      (function(){
        var element = _this.elements[i];
        element.addEventListener("dragstart",function(e){ _this.dragBegin(this,e); });
        element.addEventListener("dragenter",function(e){ _this.dragOver(this,e); });
        element.addEventListener("dragend",function(e){ _this.dragEnd(this,e); });
        element.addEventListener("drop",function(e){ e.preventDefault(); return false; });

        // LI
        element.setAttribute("draggable", true);
        // A
        element.children[0].setAttribute("draggable", false);
        // IMG
        element.querySelector("img").setAttribute("draggable", false);

        // Mark Image
        element.querySelector("[type='checkbox']").addEventListener("change",function(e){
          element.classList.toggle("selected",this.checked);
        });
      })();
    }
window.CP.exitedLoop(1);

  };
  
  this.reorder = function(element,target){
    var parent = element.parentElement;
    if(parent == target.parentElement){
      var children = Array.prototype.slice.call(parent.children);
      var indexElement = children.indexOf(element);
      var indexTarget = children.indexOf(target);
      
      if(indexTarget >= children.length - 1){
        parent.appendChild(element);
      }else if(indexTarget == indexElement + 1){
        parent.insertBefore(element,children[indexTarget + 1]);
      }else{
        parent.insertBefore(element,target);
      }
    }
  };
  
  this.dragBegin = function(element,e){
    this.current = element;
    element.classList.add('dragging');
    e.dataTransfer.setData('text/plain', "It’s Dangerous to go Alone! Take This")
  };
  
  this.dragOver = function(element,e){
    if(element !== this.current){
      this.reorder(this.current,element);
    }
  };
  
  this.dragEnd = function(element,e){
    element.classList.remove('dragging');
    this.current = undefined;
    e.preventDefault();
  };
  
  // And now: Turn this mo'fucka' on!
  this.init(target);
}

var teste = new coolGallery(".cool-gallery");


</script>