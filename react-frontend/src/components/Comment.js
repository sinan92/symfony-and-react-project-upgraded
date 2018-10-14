import React from 'react';
import {Link} from 'react-router';

class Comment extends React.Component {
    render(){
        return (
          <div>
              <li class="mdl-list__item mdl-list__item--three-line">
                <span class="mdl-list__item-primary-content">
                <i class="material-icons mdl-list__item-avatar">person</i>
                <span>Bryan Cranston</span>
                <span class="mdl-list__item-text-body">
                    Bryan Cranston played the role of Walter in Breaking Bad. He is also known
                    for playing Hal in Malcom in the Middle.
                </span>
                </span>
                <span class="mdl-list__item-secondary-content">
                <a class="mdl-list__item-secondary-action" href="#"><i class="material-icons">star</i></a>
                </span>
            </li>
          </div>
        );
    }
}

export default Comment;