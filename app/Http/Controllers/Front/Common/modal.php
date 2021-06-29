<!-- 案件詳細 削除ボタン -->
<div class="l-modal" :class="{'open': isModalTrash}">
	<div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalTrush">
		<div class="l-modal__iosModel">
			<div class="l-modal__iosModel__inner">
				<p class="c-sentence textCenter">本当に削除しても<br>よろしいでしょうか？</p>
				<ul class="l-flex trueFalse">
					<li><a @click.self="toggleModalTrush">いいえ</a></li>
					<li><a href="">はい</a></li>
				</ul>
			</div>

		</div>
	</div>
</div>

<!-- 案件詳細 現場確定ボタン -->
<div class="l-modal" :class="{'open': isModalConfirm}">
	<div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalConfirm">
		<div class="l-modal__iosModel">
			<div class="l-modal__iosModel__inner">
				<p class="c-sentence textCenter">本当に削除しても<br>よろしいでしょうか？</p>
				<ul class="l-flex trueFalse">
					<li><a @click.self="toggleModalConfirm">いいえ</a></li>
					<li><a href="">はい</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>


<!-- 案件詳細 現場完了ボタン -->
<div class="l-modal" :class="{'open': isModalComplete}">
	<div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalComplete">
		<div class="l-modal__iosModel">
			<div class="l-modal__iosModel__inner">
				<p class="c-sentence textCenter">現場完了後、<br>全ての編集が不可となります。<br>よろしいでしょうか？</p>
				<ul class="l-flex trueFalse">
					<li><a @click.self="toggleModalComplete">いいえ</a></li>
					<li><a href="">はい</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<!-- 見積書詳細 -->
<div class="l-modal" :class="{'open': isModalInvoiceAdd}">
	<div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleModalInvoiceAdd">
		<div class="l-modal--area__input">
			<div class="l-modal--area__input__box">
				<label>品番・品名</label>
				<input type="text" name="">
			</div>
			<div class="l-modal--area__input__box">
				<label>数量</label>
				<input @input="validateUnit" v-model="unitNumber">
			</div>
			<div class="l-modal--area__input__box">
				<label>単位</label>
				<input type="text" name="">
			</div>
			<div class="l-modal--area__input__box">
				<label>単価</label>
				<input @input="validatePrice" v-model="unitPrice">
			</div>
			<div class="l-modal--area__input__box">
				<label>金額</label>
				<span>{{ sum }}</span>
			</div>
			<div class="l-modal--area__input__submit l-button--submit">
				<input class="c-button--yellowRounded" type="submit" name="" value="登録">
			</div>
		</div>
	</div>
</div>

<!-- 銀行口座編集 -->
<div class="l-modal" :class="{'open': isBankEdit}">
	<div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleBankEdit">
		<div class="l-modal__iosModel">
			<div class="l-modak__list"><a href="">メインにする</a></div>
			<div class="l-modak__list"><a href="">編集する</a></div>
			<div class="l-modak__list"><a href="">削除する</a></div>
		</div>
	</div>
</div>

<!-- 営業担当修正 -->
<div class="l-modal" :class="{'open': isMemberEdit}">
	<div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleMemberEdit">
		<div class="l-modal__iosModel">
			<div class="l-modak__list"><a href="">編集する</a></div>
			<div class="l-modak__list"><a href="">削除する</a></div>
		</div>
	</div>
</div>

<!-- お客様修正 -->
<div class="l-modal" :class="{'open': isClientEdit}">
	<div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleClientEdit">
		<div class="l-modal__iosModel">
			<div class="l-modak__list"><a href="">編集する</a></div>
			<div class="l-modak__list"><a href="">削除する</a></div>
		</div>
	</div>
</div>

<!-- 職人修正 -->
<div class="l-modal" :class="{'open': isWorkerEdit}">
	<div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleWorkerEdit">
		<div class="l-modal__iosModel">
			<div class="l-modak__list"><a href="">編集する</a></div>
			<div class="l-modak__list"><a href="">削除する</a></div>
		</div>
	</div>
</div>



<!-- 職人用：案件詳細 現場完了ボタン -->
<div class="l-modal" :class="{'open': isWorkerTypeQuestion}">
	<div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleWorkerTypeQuestion">
		<div class="l-modal__iosModel">
			<div class="l-modal__iosModel__inner">
				<p class="c-sentence textCenter">職長ですか？<br>子方ですか？</p>
				<ul class="l-flex trueFalse">
					<li><a>職長です</a></li>
					<li><a>子方です</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<!-- 職人用：項目追加 -->



